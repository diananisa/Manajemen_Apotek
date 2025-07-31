<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Product;

class CartController extends Controller
{
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
        
        if (!$produk || $produk->Jumlah <= 0) {
            return back()->with('error', 'Stok produk habis atau tidak ditemukan.');
        }

        if (!session()->has('kode_transaksi')) {
            session(['kode_transaksi' => 'TRX' . now()->format('YmdHis') . rand(100, 999)]);
        }

        $cart = session()->get('cart', []);

        $id = $produk->Id_Obat;
        $cart[$id] = [
            'Id_Obat' => $produk->Id_Obat,
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
        $metode = $request->metode;
        $kode = $request->kode;

        // Ambil cart dari session
        $cartItems = session('cart', []);
        $total = 0;

        foreach ($cartItems as $item) {
            $harga = is_numeric($item['Harga_Jual']) ? $item['Harga_Jual'] : 0;
            $qty = is_numeric($item['quantity']) ? $item['quantity'] : 0;
            $total += $harga * $qty;
        }

        $dibayar = $request->input('dibayar');
        $kembali = $dibayar - $total;

        // Simpan ke session untuk digunakan di struk
        session([
            'uang_dibayar' => $dibayar,
            'uang_kembali' => $kembali,
        ]);

        \Log::info("Redirect ke metode: $metode");
        \Log::info("Kode yang diterima di bayar: $kode");

        Transaction::where('Kode_Transaksi', $kode)->update([
            'Metode_Pembelian' => $metode,
        ]);

        return redirect()->route('method.' . $metode, ['kode' => $kode]);
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
        $metode = $request->input('metode');
        
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
                'Id_Obat'           => $item['Id_Obat'],
                'Kode_Transaksi'    => $Kode_Transaksi,
                'Tanggal_Transaksi' => $Tanggal_Transaksi,
                'Nama_Obat'         => $item['Nama_Obat'],
                'Jumlah'            => $item['quantity'],
                'Harga_Satuan'      => $item['Harga_Jual'],
                'Total_Harga'       => $subtotal,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            DB::table('_stock__produk')
                ->where('Id_Obat', $item['Id_Obat'])
                ->decrement('Jumlah', $item['quantity']);
        }

        // Jangan simpan metode di sini
        Transaction::create([
            'Kode_Transaksi'    => $Kode_Transaksi,
            'Tanggal_Transaksi' => $Tanggal_Transaksi,
            'Total'             => $total,
            'Metode_Pembelian'  => $metode,
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

    public function printPDF(Request $request)
    {
        $kode = $request->query('kode');
        $dibayar = session('uang_dibayar');
        $kembali = session('uang_kembali');
        $metode = $request->query('metode');

        $carts = DB::table('carts')->where('Kode_Transaksi', $kode)->get();
        $transaksi = Transaction::where('Kode_Transaksi', $kode)->first();

        if (!$transaksi) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $total = $transaksi->Total;
        $terbilang = $this->terbilang($total) . ' Rupiah';

        $pdf = PDF::loadView('Cart.struk', [
            'carts' => $carts,
            'kode' => $kode,
            'tanggal' => $transaksi->Tanggal_Transaksi,
            'total' => $total,
            'terbilang' => $terbilang,
            'dibayar' => $dibayar,
            'kembali' => $kembali,
            'metode' => $transaksi->Metode_Pembelian,
        ]);

        return $pdf->stream('struk_' . $kode . '.pdf');
    }

    public function cash(Request $request, $kode)
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $grandTotal = 0;
        foreach ($cartItems as $item) {
            $harga = is_numeric($item['Harga_Jual']) ? $item['Harga_Jual'] : 0;
            $qty = is_numeric($item['quantity']) ? $item['quantity'] : 0;
            $grandTotal += $harga * $qty;
        }
        
        // Default
        $dibayar = null;
        $kembalian = null;
        $errorKembalian = null;
        
        // Kalau POST (user input "dibayar")
        if ($request->isMethod('post')) {
            $dibayar = (int) $request->input('dibayar');
            $kembalian = $dibayar - $grandTotal;
            if ($kembalian < 0) {
                $errorKembalian = 'Uang dibayar kurang dari total belanja!';
            }
            else
            {
                session([
                    'uang_dibayar' => $dibayar,
                    'uang_kembali' => $kembalian,
                ]);
            }
        }

        return view('Cart.cash', [
            'cartItems' => $cartItems,
            'kode' => $kode,
            'total' => $grandTotal,
            'terbilang' => $this->terbilang($grandTotal) . ' Rupiah',
            'kasir' => 'Admin Apotek',
            'dibayar' => $dibayar,
            'kembalian' => $kembalian,
            'errorKembalian' => $errorKembalian,
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

    public function updateQty(Request $request, $id, $mode)
    {
        $cart = session()->get('cart', []);
        $produk = Product::where('Id_Obat', $id)->first();

        if (!$produk || !isset($cart[$id])) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $stokTersedia = $produk->Jumlah;
        $jumlahSekarang = $cart[$id]['quantity'];

        if ($mode === 'increase') {
            if ($jumlahSekarang >= $stokTersedia) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk menambah item.');
            }

            $cart[$id]['quantity']++;
        } elseif ($mode === 'decrease') {
            if ($jumlahSekarang > 1) {
                $cart[$id]['quantity']--;
            }
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }
}
