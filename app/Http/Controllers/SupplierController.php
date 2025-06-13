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
    //menampilkan form edit
    public function edit(string $Id_supplier)
    {
        $suppliers = Supplier::findOrFail($Id_supplier);
        return view('supplier.edit', compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    //memperbaharui data
    public function update(Request $request, string $Id_supplier)
    {
        $supplier = Supplier::findOrFail($Id_supplier);

        $request->validate([
            'Id_supplier' => 'required|unique:_supplier,Id_Supplier|max:10' . $supplier->Id_Supplier,
            'Nama_Produck' => 'required',
            'Tanggal_Masuk' => 'required',
            'Tanggal_Kadaluarsa' => 'required',
            'Jumlah' => 'required',
            'Total_Harga' => 'required',
        ]);

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
