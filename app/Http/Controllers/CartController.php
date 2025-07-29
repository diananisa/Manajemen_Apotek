<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cart;
use App\Models\Transaction;

class CartController extends Controller
{
    public function CartUpdate()
    {
        // Implementasi update cart jika dibutuhkan
    }

    public function cartView()
    {
        $cart = session()->get('cart', []);
        return view('Cart.cart', compact('cart'));
    }

    public function method(Request $request)
    {
        $kode = $request->query('kode'); // ← Ambil kode dari query string

        if (!$kode) {
            return redirect()->route('cart.view')->with('error', 'Tidak ada transaksi tersedia!');
        }

        return view('Cart.method', compact('kode'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $Kode_Transaksi = 'TRX' . now()->format('YmdHis') . rand(100, 999);
        $Tanggal_Transaksi = now();
        $total = 0;

        // Simpan item satu per satu ke tabel carts
        foreach ($cart as $item) {
            $subtotal = $item['Harga_Jual'] * $item['quantity'];
            $total += $subtotal;

            DB::table('carts')->insert([
                'Kode_Transaksi'    => $Kode_Transaksi,
                'Tanggal_Transaksi' => $Tanggal_Transaksi,
                'Nama_Obat'         => $item['Nama_Obat'],
                'Jumlah'            => $item['quantity'],
                'Harga_Satuan'      => $item['Harga_Jual'],
                'Total_Harga'       => $subtotal,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // Simpan ke tabel transactions (jika belum ada model Transaction, bisa pakai DB::table)
        Transaction::create([
            'Kode_Transaksi'    => $Kode_Transaksi,
            'Tanggal_Transaksi' => $Tanggal_Transaksi,
            'Total'             => $total,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        session()->forget('cart');
        session()->put('Kode_Transaksi_Terakhir', $Kode_Transaksi);

        return redirect()->route('Cart.method', ['kode' => $Kode_Transaksi]);
    }

    private function terbilang($angka)
    {
        $f = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);
        return ucfirst($f->format($angka));
    }

    public function cetakPDF($kode)
    {
        $carts = Cart::where('Kode_Transaksi', $kode)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Transaksi tidak ditemukan!');
        }

        $tanggal = $carts->first()->Tanggal_Transaksi;
        $total = $carts->sum('Total_Harga');

        $pdf = Pdf::loadView('Cart.struk', [
            'carts' => $carts,
            'tanggal' => $tanggal,
            'kode' => $kode,
            'kasir' => 'Admin Apotek',
            'total' => $total,
            'terbilang' => $this->terbilang($total) . ' Rupiah'
        ]);

        return $pdf->stream("struk-{$kode}.pdf");
    }

    // 🛠️ Jika cash() hanya menampilkan struk ulang, sebaiknya gabungkan logikanya seperti cetakPDF
    public function cash($kode)
    {
        $carts = \App\Models\Cart::where('Kode_Transaksi', $kode)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Transaksi tidak ditemukan!');
        }

        $tanggal = $carts->first()->Tanggal_Transaksi;
        $total = $carts->sum('Total_Harga');

        return view('Cart.cash', [
            'carts' => $carts,
            'cart' => $carts->first(),
            'tanggal' => $tanggal,
            'kode' => $kode,
            'kasir' => 'Admin Apotek',
            'total' => $total,
            'terbilang' => $this->terbilang($total) . ' Rupiah'
        ]);
    }

    public function qris()
    {
        return view('Cart.qris');
    }
}
