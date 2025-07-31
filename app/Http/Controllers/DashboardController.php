<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\StokProduk;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $stokStatus = $this->getStokKadaluarsa(Carbon::today());
        $stokKadaluarsa = $this->getStokKadaluarsa($today);
        $stokJumlah = $this->getStok();

        $chartData = [
            'Aman' => $stokKadaluarsa->where('status', 'Aman')->count(),
            'Hampir Kadaluarsa' => $stokKadaluarsa->where('status', 'Hampir Kadaluarsa')->count(),
            'Kadaluarsa' => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
        ];

        $stokChart = [
            'Habis' => $stokJumlah->where('status', 'Habis')->count(),
            'Hampir Habis' => $stokJumlah->where('status', 'Hampir Habis')->count(),
            'Menipis' => $stokJumlah->where('status', 'Menipis')->count(),
            'Banyak' => $stokJumlah->where('status', 'Banyak')->count(),
        ];

        return view('dashboard_apoteker', [
            'tanggalFilter' => $today->toDateString(),
            'produkAktif' => StokProduk::where('Jumlah', '>', 0)->count(),
            'stokMenipis' => StokProduk::whereBetween('Jumlah', [1, 50])->count(),
            'chartData' => $chartData,
            'stokChart' => $stokChart,
            'obatKadaluarsa' => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
            'stokKadaluarsa' => $stokKadaluarsa,
            'supplierAktif' => Supplier::where('status', 'on')->count(),
            'supplierNonaktif' => Supplier::where('status', '!=', 'on')->count(),
            'stok' => $stokJumlah,
        ]);
    }

    private function getStokKadaluarsa(Carbon $today)
    {
        $next7Days = $today->copy()->addDays(7);

        return StokProduk::where('Jumlah', '>', 0)->get()->map(function ($item) use ($today, $next7Days)
        {
            $exp = Carbon::parse($item->Tanggal_Kadaluarsa);
            $sisaHari = $today->diffInDays($exp, false);

            if ($exp->isSameDay($today)) {
                $item->status = 'Kadaluarsa';
                $item->badge = 'danger';
                $item->sisa_hari = 0;
                $item->priority = 1;
            } elseif ($exp->lt($today)) {
                $item->status = 'Kadaluarsa';
                $item->badge = 'danger';
                $item->sisa_hari = null;
                $item->priority = 1;
            } elseif ($exp->between($today, $next7Days)) {
                $item->status = 'Hampir Kadaluarsa';
                $item->badge = 'warning';
                $item->sisa_hari = $sisaHari;
                $item->priority = 2;
            } else {
                $item->status = 'Aman';
                $item->badge = 'success';
                $item->sisa_hari = $sisaHari;
                $item->priority = 3;
            }

            return $item;
        })->sortBy('priority')->values();
    }

    private function getStok()
    {
        return StokProduk::get()->map(function ($item)
        {
            if ($item->Jumlah == 0) {
                $item->status = 'Habis';
                $item->badge = 'dark';
            } elseif ($item->Jumlah <= 10) {
                $item->status = 'Hampir Habis';
                $item->badge = 'danger';
            } elseif ($item->Jumlah <= 50) {
                $item->status = 'Menipis';
                $item->badge = 'warning';
            } else {
                $item->status = 'Banyak';
                $item->badge = 'success';
            }

            return $item;
        });
    }
}
