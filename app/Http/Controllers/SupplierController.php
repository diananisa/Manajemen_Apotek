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
        return view('Supplier.index', compact('suppliers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        return view('Supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    //menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'Id_supplier' => 'required|unique:_supplier,Id_Supplier|max:10',
            'Nama_Supplier' => 'required',
            'Kontak' => 'required',
            'Alamat' => 'required',
            'Jenis_Barang_Obat' => 'required',
            'Nama_PIC' => 'required',
            'Status'=> 'required',
        ], [
            'Id_supplier.required' => 'Kolom ID Supplier harus diisi.',
            'Id_supplier.unique' => 'ID Supplier sudah digunakan.',
            'Nama_Supplier.required' => 'Kolom Nama Supplier harus diisi.',
            'Kontak.required' => 'Kolom Kontak harus diisi.',
            'Alamat.required' => 'Kolom Alamat harus diisi.',
            'Jenis_Barang_Obat.required' => 'Jenis Barang/Obat harus diisi.',
            'Nama_PIC.required' => 'Nama PIC harus diisi.',
        ]);
        Supplier::create([
            'Id_supplier' => $request->Id_supplier,
            'Nama_Supplier' => $request->Nama_Supplier,
            'Kontak' => $request->Kontak,
            'Alamat' => $request->Alamat,
            'Jenis_Barang_Obat' => $request->Jenis_Barang_Obat,
            'Nama_PIC' => $request->Nama_PIC,
            'Status' =>$request->Status,

        ]);
        // Supplier::create($request->all());
        return redirect()->route('Supplier.index')->with('success', 'Data Berhasil disimpan');
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
    public function edit($Id_supplier)
    {
       
        $supplier = Supplier::where('Id_supplier',$Id_supplier)->firstOrFail();
        return view('Supplier.edit', compact('supplier'));

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
    public function update(Request $request)
    {
        $request->validate([
            'Id_supplier' => 'required',
            'Nama_Supplier' => 'required',
            'Kontak' => 'required',
            'Alamat' => 'required',
            'Jenis_Barang_Obat' => 'required',
            'Nama_PIC' => 'required',
            'Status'=>'required',
        ]);

        // $supplier = Supplier::findOrFail($Id_supplier);
        Supplier::where('Id_supplier', $request->Id_supplier)->update([

            // ''=>$request->Id_supplier,
            'Nama_Supplier'=>$request->Nama_Supplier,
            'Kontak'=>$request->Kontak,
            'Alamat'=>$request->Alamat,
            'Jenis_Barang_Obat'=>$request->Jenis_Barang_Obat,
            'Nama_PIC'=>$request->Nama_PIC,
            'Status'=>$request->Status,
        ]);



        // $request->save();
        //$request->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    //menghapus
    public function destroy(string $Id_supplier)
    {
        $supplier = Supplier::where('Id_supplier',$Id_supplier)->firstOrFail();

        //$supplier = Supplier::findOrFail($Id_supplier);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'data berhasi dihapus');
    }
}
