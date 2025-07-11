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
        return view('product.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        return view('product.add');
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
            'Tanggal_Kadaluarsa' => 'required',
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
            'Tanggal_Kadaluarsa' => $request->Tanggal_Kadaluarsa,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $request->Total_Harga,

        ]);
        // Supplier::create($request->all());
        return redirect()->route('product.index')->with('success', 'Data Berhasil disimpan');
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
        return view('product.edit', compact('product'));

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
            'Tanggal_Kadaluarsa' => 'required',
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
            'Tanggal_Kadaluarsa' => $request->Tanggal_Kadaluarsa,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $request->Total_Harga,
        ]);

        return redirect()->route('product.index')->with('success', 'Data berhasil diupdate');
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
        $procuct = Product::where('Id_Obat',$Id_Obat)->firstOrFail();

        //$supplier = Supplier::findOrFail($Id_supplier);
        $procuct->delete();

        return redirect()->route('product.index')->with('success', 'data berhasi dihapus');
    }
}
