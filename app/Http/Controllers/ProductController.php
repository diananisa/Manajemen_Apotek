<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); //mengambil semua data dari tabel supplier
        return view('Product.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        // return view('Product.add');
        $suppliers = Supplier::all();
        return view('Product.add', compact('suppliers'));
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
    // public function getSupplierById($id)
    // {
    //     $supplier = Supplier::where('Id_supplier', $id)->first();

    //     if (!$supplier)
    //     {
    //         return response()->json(['eror' => 'Supplier tidak ditemukan'], 404);
    //     }

    //     return response()->json([
    //         'Nama_Produck' => $supplier->Nama_Produck,
    //         // 'alamat' => $supplier->alamat,
    //         'Tanggal_Masuk'   => $supplier->Tanggal_Masuk,
    //         'Tanggal_Kadaluarsa' => $supplier->Tanggal_Kadaluarsa,
    //         'Jumlah'            => $supplier->Jumlah,
    //         'Total_Harga'     => $supplier->Total_Harga,
    //     ]);
    // }
   

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



        // $request->save();
        //$request->update($request->all());

        // return redirect()->route('product.index')->with('success', 'Data berhasil diupdate');

    // }

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

    public function utama()
    {
        $products = Product::all(); // atau gunakan pagination: Product::paginate(12)
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
                // "Total_Harga" => $product->Total_Harga,
                "Harga_Jual" => $product->Harga_Jual,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Produk berhasil ditambahkan ke keranjang!');

    }

    public function laporan()
    {
        $products = Product::all();
        return view('Product.laporan', compact('products'));
    }

}
