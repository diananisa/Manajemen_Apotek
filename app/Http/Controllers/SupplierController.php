<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers      = Supplier::all();
        $search         = $request->get('search');
        $query          = Supplier::query();

        // Search Nama Supplier
        if ($search) {
            $query->where('Nama_Supplier', 'like', "%{$search}%");
        }

        // Ambil data
        $suppliers = $query->paginate(15)->appends($request->query());

        return view('Supplier.index', compact('suppliers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    //tambah supplier
    public function create()
    {
        // Generate ID Supplier baru, contoh format SUP-001
        $lastSupplier = Supplier::orderBy('Id_supplier', 'desc')->first();
        if ($lastSupplier) {
            $lastNumber = (int) str_replace('SUP-', '', $lastSupplier->Id_supplier);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        $newId = 'SUP-' . $newNumber;

        return view('Supplier.add', [
            'suppliers' => (object) ['Id_supplier' => $newId]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    //menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'Id_supplier' => 'required|unique:_supplier,Id_supplier',
            'Nama_Supplier' => 'required',
            'Kontak' => 'required',
            'Alamat' => 'required',
            'Jenis_Barang_Obat' => 'required',
            'Nama_PIC' => 'required',
            'Status'=> 'required',
        ], [
            'Id_supplier.required' => '-',
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
            'Status' => $request->Status,

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
            'Status' => $request->Status,
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
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'data berhasi dihapus');
    }
    
    public function laporan(Request $request)
    {
        $search         = $request->get('search');
        $query          = Supplier::query();
        
        // Search Nama Supplier
        if ($search) {
            $query->where('Nama_Supplier', 'like', "%{$search}%");
        }
        
        // Ambil data
        $suppliers = $query->paginate(15)->appends($request->query());
        
        
        return view('Supplier.laporan', compact('suppliers', 'search'));
    }

}
