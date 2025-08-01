<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products       = Product::all();
        $search         = $request->get('search');
        $query          = Product::query();

        // Search Nama Obat
        if ($search) {
            $query->where('Nama_Obat', 'like', "%{$search}%");
        }

        $products = $query->paginate(15)->appends($request->query());

        return view('Product.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        $suppliers = Supplier::all();

        // Ambil ID terakhir
        $lastId = Product::orderBy('Id_Obat', 'desc')->value('Id_Obat');

        if ($lastId) {
            // Ambil angka setelah "OBT-"
            $num = (int) substr($lastId, 4);
            $num++;
        } else {
            $num = 1;
        }

        $newId = 'OBT-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        return view('Product.add', compact('suppliers', 'newId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    //menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Id_Obat' => 'required|unique:_stock__produk,Id_Obat|max:10',
            'Nama_Obat' => 'required',
            'supplier_id' => 'required',
            'Tanggal_Kadaluarsa' => 'required',
            'Harga_Jual' => 'required',
            'Jenis_Satuan' => 'required',
            'Jumlah' => 'required',
            'Total_Harga' => 'required',
        ]);

        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $namaFile);
        }

        Product::create([
            'gambar' => $namaFile,
            'Id_Obat' => $request->Id_Obat,
            'Nama_Obat' => $request->Nama_Obat,
            'supplier_id' => $request->supplier_id,
            'Tanggal_Kadaluarsa' => $request->Tanggal_Kadaluarsa,
            'Harga_Jual' => $request->Harga_Jual,
            'Jenis_Satuan' => $request->Jenis_Satuan,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $request->Total_Harga,

        ]);
        // Supplier::create($request->all());
        return redirect()->route('Product.index')->with('success', 'Data Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Id_Obat)
    {
       
        $product = Product::where('Id_Obat',$Id_Obat)->firstOrFail();
        $suppliers = Supplier::all();
        
        return view('Product.edit', compact('product', 'suppliers'));
    }   

    /**
     * Update the specified resource in storage.
     */
    //memperbaharui data
    public function update(Request $request, $Id_Obat)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Nama_Obat' => 'required',
            'supplier_id' => 'required',
            'Tanggal_Kadaluarsa' => 'required',
            'Harga_Jual' => 'required',
            'Jenis_Satuan' => 'required',
            'Jumlah' => 'required',
            'Total_Harga' => 'required',
        ]);

        $product = Product::where('Id_Obat', $Id_Obat)->firstOrFail();

        $namaFile = $product->gambar; // default: gambar lama

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $namaFile);
        }

        $product->update([
            'gambar' => $namaFile,
            'Nama_Obat' => $request->Nama_Obat,
            'supplier_id' => $request->supplier_id,
            'Tanggal_Kadaluarsa' => $request->Tanggal_Kadaluarsa,
            'Harga_Jual' => $request->Harga_Jual,
            'Jenis_Satuan' => $request->Jenis_Satuan,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $request->Total_Harga,
        ]);

        return redirect()->route('Product.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    //menghapus
    public function destroy(string $Id_Obat)
    {
        $product = Product::where('Id_Obat',$Id_Obat)->firstOrFail();

        //$supplier = Supplier::findOrFail($Id_supplier);
        $product->delete();

        return redirect()->route('Product.index')->with('success', 'data berhasi dihapus');
    }

    public function utama(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
                return $query->where('Nama_Obat', 'like', '%' . $search . '%');
            })
            ->orderByRaw('Jumlah = 0')      // Stok kosong di bawah
            ->orderByDesc('Jumlah')         // Stok besar ke kecil
            ->get();

        return view('Product.utama', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $Id_Obat = $request->input('Id_Obat');
        $product = Product::where('Id_Obat', $Id_Obat)->firstOrFail();

        $cart = session()->get('cart', []);

        if (isset($cart[$Id_Obat])) {
            $cart[$Id_Obat]['quantity']++;
        } else {
            $cart[$Id_Obat] = [
                "Nama_Obat" => $product->Nama_Obat,
                "gambar" => $product->gambar,
                "Harga_Jual" => $product->Harga_Jual,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    

    public function laporan(Request $request)
    {
        $search       = $request->get('search');
        $jenisObat    = $request->get('jenis_obat');
        $statusStock  = $request->get('status_stock');
        $sortBy       = $request->get('sort_by', 'Tanggal_Kadaluarsa');
        
        $sortDir      = $request->get('sort_dir', 'desc');

        $query = Product::with('supplier');

        // Search Nama Obat
        if ($search) {
            $query->where('Nama_Obat', 'like', "%{$search}%");
        }

        // Filter Jenis Obat
        if ($jenisObat) {
            $query->whereHas('supplier', function ($q) use ($jenisObat) {
                $q->where('Jenis_Barang_Obat', $jenisObat);
            });
        }

        // Filter Status Stock
        if ($statusStock) {
            switch ($statusStock) {
                case 'banyak':     $query->where('Jumlah', '>', 50); break;
                case 'menipis':  $query->whereBetween('Jumlah', [11, 50]); break;
                case 'hampir_habis':   $query->whereBetween('Jumlah', [1, 10]); break;
                case 'habis':    $query->where('Jumlah', 0); break;
            }
        }

        // Sorting
        $allowedSort = ['Id_Obat', 'Nama_Obat', 'Tanggal_Kadaluarsa', 'Jumlah'];
        if (! in_array($sortBy, $allowedSort)) {
            $sortBy = 'Tanggal_Kadaluarsa';
        }
        $sortDir = $sortDir === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortBy, $sortDir);

        // Ambil data
        $products = $query->paginate(15)->appends($request->query());

        // Ambil daftar Jenis Obat untuk dropdown
        $jenisOptions = Product::with('supplier')
            ->get()
            ->pluck('supplier.Jenis_Barang_Obat')
            ->filter()
            ->unique()
            ->values();

        return view('Product.laporan', compact(
            'products', 'jenisOptions', 'search', 'jenisObat', 'statusStock', 'sortBy', 'sortDir'
        ));
    }

    public function kadaluarsa()
    {
        $today = Carbon::today();

        $products = Product::select('Nama_Obat', 'Tanggal_Kadaluarsa', 'Tanggal_Masuk', 'Jumlah')
            ->get()
            ->map(function ($product) use ($today) {
                $kadaluarsa = Carbon::parse($product->Tanggal_Kadaluarsa);
                $diffDays = $today->diffInDays($kadaluarsa, false);

                if ($diffDays < 0) {
                    $product->status = 'Sudah Kadaluarsa';
                    $product->badge = 'danger';
                } elseif ($diffDays <= 30) {
                    $product->status = 'Segera Kadaluarsa';
                    $product->badge = 'warning text-dark';
                } else {
                    $product->status = 'Aman';
                    $product->badge = 'success';
                }

                return $product;
            });

        return view('Product.kadaluarsa', compact('products'));
    }

}
