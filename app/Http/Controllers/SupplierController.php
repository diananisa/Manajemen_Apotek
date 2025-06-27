<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all(); //mengambil semua data dari tabel supplier
        return view('supplier.index', compact('suppliers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        return view('supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    //menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'Id_supplier' => 'required|unique:_supplier,Id_Supplier|max:10',
            'Nama_Produck' => 'required',
            'Tanggal_Masuk' => 'required',
            'Tanggal_Kadaluarsa' => 'required',
            'Jumlah' => 'required',
            'Total_Harga' => 'required',
        ]);
        Supplier::create([
            'Id_supplier' => $request->Id_supplier,
            'Nama_Produck' => $request->Nama_Produck,
            'Tanggal_Masuk' => $request->Tanggal_Masuk,
            'Tanggal_Kadaluarsa' => $request->Tanggal_Kadaluarsa,
            'Jumlah' => $request->Jumlah,
            'Total_Harga' => $request->Total_Harga,

        ]);
        // Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success', 'Data Berhasil disimpan');
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
    public function edit($id)
    {
       
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));

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
    public function update(Request $request, string $Id_supplier)
    {
        $supplier = Supplier::findOrFail($Id_supplier);

        // $supplier->Id_supplier = $request->Id_supplier;
        $supplier->Nama_Produck = $request->Nama_Produck;
        $supplier->Tanggal_Masuk = $request->Tanggal_Masuk;
        $supplier->Tanggal_Kadaluarsa = $request->Tanggal_Kadaluarsa;
        $supplier->Jumlah = $request->Jumlah;
        $supplier->Total_Harga = $request->Total_Harga;

        $request->validate([
            'Id_supplier' => 'required|unique:_supplier,Id_Supplier|max:10' . $supplier->Id_Supplier,
            'Nama_Produck' => 'required',
            'Tanggal_Masuk' => 'required',
            'Tanggal_Kadaluarsa' => 'required',
            'Jumlah' => 'required',
            'Total_Harga' => 'required',
        ]);

        $supplier->save();
        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    //menghapus
    public function destroy(string $Id_supplier)
    {
        $supplier = Supplier::findOrFail($Id_supplier);
        $supplier->delete();

        return redirect()->route('supplier.destroy')->with('succes', 'data berhasi dihapus');
    }
}
