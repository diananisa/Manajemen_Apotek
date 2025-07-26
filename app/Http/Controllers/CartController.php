<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;



class CartController extends Controller
{
    public function CartUpdate(){

    }

    public function cartView()
    {
        $cart = session()->get('cart', []);
        return view('cart.cart', compact('cart'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $Kode_Transaksi = 'TRX' . now()->format('YmdHis') . rand(100, 999);
        $Tanggal_Transaksi = now();

        foreach ($cart as $item) {
            DB::table('carts')->insert([
                'Kode_Transaksi'    => $Kode_Transaksi,
                'Tanggal_Transaksi' => $Tanggal_Transaksi,
                'Nama_Obat'         => $item['Nama_Obat'],
                'Jumlah'            => $item['quantity'],
                'Harga_Satuan'      => $item['Total_Harga'],
                'Total_Harga'       => $item['Total_Harga'] * $item['quantity'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        session()->forget('cart');

        // Redirect ke PDF, pastikan parameter kode dikirim
        // return redirect()->route('struk.pdf', ['kode' => $Kode_Transaksi]);
    }


    // public function struk()
    // {
    //     $items = DB::table('carts')->where('Kode_Transaksi', $kode_transaksi)->get();

    //     if ($items->isEmpty()) {
    //         abort(404, 'Transaksi tidak ditemukan.');
    //     }

    //     $tanggal = $items->first()->Tanggal_Transaksi;
    //     $total = $items->sum('Total_Harga');

    //     return view('receipt', [
    //         'items' => $items,
    //         'tanggal' => $tanggal,
    //         'kode_transaksi' => $kode_transaksi,
    //         'kasir' => 'Admin Apotek', // atau dari session login
    //         'total' => $total,
    //         'terbilang' => $this->terbilang($total) . ' Rupiah',
    //         // 'metode' => 'Qris'
    //     ]);

    //     return redirect()->route('struk')->with('success', 'Struk akan segera keluar!');

    // }

    // Fungsi bantu terbilang
    private function terbilang($angka)
    {
        $f = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);
        return ucfirst($f->format($angka));
    }

    public function cetakPDF($kode)
    {
        $cart = \App\Models\Cart::where('Kode_Transaksi', $kode)->first();
        if (!$cart) {
            return back()->with('error', 'Transaksi tidak ditemukan!');
        }

        $pdf = \PDF::loadView('Cart.struk', compact('Cart'));
        return $pdf->stream("struk-{$cart->Kode_Transaksi}.pdf");
    }

    public function cash()
    {
        $struk = Transaksi::latest()->first(); // atau logika sesuai kebutuhan kamu

        return view('Cart.cash', compact('cart'));
    }







    // public function cetakPDF($id)
    // {
    //     $cart = Cart::findOrFail($id);
    //     $pdf = PDF::loadView('struk.cart', compact('cart'));

    //     return $pdf->stream("struk-cart-{$cart->Kode_Transaksi}.pdf");
    // }

    public function items()
    {
        return $this->hasMany(ItemCart::class, 'kode_transaksi', 'Kode_Transaksi');
    }





}
