<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cart;
use App\Models\Transaction;

class CartController extends Controller
{
    public function CartUpdate()
    {
        // Implementasi update cart jika dibutuhkan
    }

    public function reset()
    {
        session()->forget(['cart', 'kode_transaksi', 'Kode_Transaksi_Terakhir']);
        return redirect()->route('product.utama');
    }

    public function addToCart(Request $request)
    {
        $produk = DB::table('_stock__produk')->where('Id_Obat', $request->Id_Obat)->first();

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan!');
        }

        if (!session()->has('kode_transaksi')) {
            session(['kode_transaksi' => 'TRX' . now()->format('YmdHis') . rand(100, 999)]);
        }

        $cart = session()->get('cart', []);

        $id = $produk->Id_Obat;
        $cart[$id] = [
            'Nama_Obat' => $produk->Nama_Obat,
            'Harga_Jual' => $produk->Harga_Jual,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function cartView()
    {
        $cartItems = session()->get('cart', []);

        $kodeTransaksi = session('kode_transaksi');

        return view('Cart.cart', compact('cartItems', 'kodeTransaksi'));
    }

    public function bayar(Request $request)
    {
        // dd('masuk ke bayar');
        // dd($request->all());

        $metode = $request->metode;
        $kode = $request->kode;

        \Log::info("Redirect ke metode: $metode");
        \Log::info("Kode yang diterima di bayar: $kode");

        Transaction::where('Kode_Transaksi', $kode)->update([
            'Metode_Pembelian' => $metode,
        ]);

        return redirect()->route('method.' . $metode, ['kode' => $kode]);

        // Log::info("Redirect ke metode: " . $request->metode);

        // $request->validate([
        //     'kode' => 'required',
        //     'metode' => 'required',
        // ]);

        // // Cek apakah transaksi sudah ada
        // $existing = Transaction::where('Kode_Transaksi', $request->kode)->first();

        // if (!$existing) {
        //     // Kalau belum ada, simpan
        //     Transaction::create([
        //         'Kode_Transaksi' => $request->kode,
        //         'Metode_Pembelian' => $request->metode,
        //         'Tanggal_Transaksi' => now(),
        //         'Total' => 0,
        //     ]);
        // } else {
        //     // Kalau sudah ada, update metode pembayaran-nya saja
        //     $existing->update([
        //         'Metode_Pembelian' => $request->metode,
        //     ]);
        // }

        // // Redirect sesuai metode
        // return match ($request->metode) {
        //     'cash' => redirect()->route('method.cash', ['kode' => $request->kode]),
        //     'qris' => redirect()->route('method.qris', ['kode' => $request->kode]),
        //     'debit' => redirect()->route('method.debit', ['kode' => $request->kode]),
        //     default => back()->withErrors(['metode' => 'Metode tidak dikenali']),
        // };
    }

    public function method(Request $request)
    {
        $kode = $request->kode ?? session('kode_transaksi');

        if (!$kode) {
            return redirect()->route('cart.view')->with('error', 'Tidak ada transaksi tersedia!');
        }

        session(['Kode_Transaksi_Terakhir' => $kode]);

        return view('Cart.method', compact('kode'));
    }

    public function checkout(Request $request)
    {
        // dd('masuk ke checkout');
        
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $Kode_Transaksi = session('kode_transaksi'); // Ambil dari session
        Log::info('Kode Transaksi Checkout: ' . $Kode_Transaksi);
        $Tanggal_Transaksi = now();
        $total = 0;

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

        // Jangan simpan metode di sini
        Transaction::create([
            'Kode_Transaksi'    => $Kode_Transaksi,
            'Tanggal_Transaksi' => $Tanggal_Transaksi,
            'Total'             => $total,
            'Metode_Pembelian'  => $request->input('metode'),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        session()->forget('cart');
        session()->put('Kode_Transaksi_Terakhir', $Kode_Transaksi);

        return redirect()->route('cart.success');
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

    public function cash($kode)
    {
        Log::info("Masuk ke halaman cash dengan kode: $kode");

        $carts = \App\Models\Cart::where('Kode_Transaksi', $kode)->get();
        Log::info('Jumlah cart ditemukan: ' . $carts->count());

        // return view('Cart.cash', compact('kode'));

        \Log::info("Masuk ke halaman cash dengan kode: " . $kode);
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

    public function qris($kode)
    {
        Transaction::where('Kode_Transaksi', $kode)->update(['Metode_Pembelian' => 'qris']);
        return view('Cart.qris', compact('kode'));
    }


    public function debit($kode)
    {
        Transaction::where('Kode_Transaksi', $kode)->update(['Metode_Pembelian' => 'debit']);
        return view('Cart.debit', compact('kode'));
    }
}
