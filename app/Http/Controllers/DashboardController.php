<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\StokProduk;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function dashboardApoteker(Request $request)
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

    public function dashboardKasir(Request $request)
{
    $filter     = $request->input('filter', 'bulan');
    $tahun      = $request->input('tahun', now()->year);
    $bulan      = $request->input('bulan', now()->month);
    $tanggal    = $request->input('tanggal', now()->toDateString());
    $tahunMulai = $request->input('tahun_mulai');
    $tahunAkhir = $request->input('tahun_akhir');

    // Ambil semua tahun transaksi
    $availableYears = DB::table('transactions')
        ->selectRaw('DISTINCT YEAR(Tanggal_Transaksi) as tahun')
        ->orderBy('tahun', 'asc')
        ->pluck('tahun');

    // Default agar tidak undefined
    $salesData = collect();

    if ($filter === 'tahun') {
        if (count($availableYears) > 3 && $tahunMulai && $tahunAkhir) {
            $salesData = DB::table('transactions')
                ->selectRaw('YEAR(Tanggal_Transaksi) as label, SUM(Total) as total_penjualan')
                ->whereBetween(DB::raw('YEAR(Tanggal_Transaksi)'), [$tahunMulai, $tahunAkhir])
                ->groupByRaw('YEAR(Tanggal_Transaksi)')
                ->orderByRaw('YEAR(Tanggal_Transaksi)')
                ->get();
        } else {
            $salesData = DB::table('transactions')
                ->selectRaw('YEAR(Tanggal_Transaksi) as label, SUM(Total) as total_penjualan')
                ->groupByRaw('YEAR(Tanggal_Transaksi)')
                ->orderByRaw('YEAR(Tanggal_Transaksi)')
                ->get();
        }

    } elseif ($filter === 'bulan') {
        $salesData = DB::table('transactions')
            ->selectRaw('MONTH(Tanggal_Transaksi) as bulan_num, MONTHNAME(Tanggal_Transaksi) as label, SUM(Total) as total_penjualan')
            ->whereYear('Tanggal_Transaksi', $tahun)
            ->groupByRaw('MONTH(Tanggal_Transaksi), MONTHNAME(Tanggal_Transaksi)')
            ->orderByRaw('bulan_num')
            ->get();

    } elseif ($filter === 'hari') {
        // Harian dalam bulan tertentu
        $salesData = DB::table('transactions')
            ->selectRaw('DAY(Tanggal_Transaksi) as hari_num, CONCAT(LPAD(DAY(Tanggal_Transaksi), 2, "0"), " ", MONTHNAME(Tanggal_Transaksi)) as label, SUM(Total) as total_penjualan')
            ->whereYear('Tanggal_Transaksi', $tahun)
            ->whereMonth('Tanggal_Transaksi', $bulan)
            ->groupByRaw('DAY(Tanggal_Transaksi), CONCAT(LPAD(DAY(Tanggal_Transaksi), 2, "0"), " ", MONTHNAME(Tanggal_Transaksi))')
            ->orderByRaw('hari_num')
            ->get();

    } elseif ($filter === 'jam') {
        // Per jam dalam hari tertentu
        $salesData = DB::table('transactions')
            ->selectRaw('HOUR(Tanggal_Transaksi) as jam_num, CONCAT(LPAD(HOUR(Tanggal_Transaksi), 2, "0"), ":00") as label, SUM(Total) as total_penjualan')
            ->whereDate('Tanggal_Transaksi', $tanggal)
            ->groupByRaw('HOUR(Tanggal_Transaksi), CONCAT(LPAD(HOUR(Tanggal_Transaksi), 2, "0"), ":00")')
            ->orderByRaw('jam_num')
            ->get();
    }

    return view('dashboard_kasir', compact(
        'salesData',
        'filter',
        'tahun',
        'bulan',
        'tanggal',
        'tahunMulai',
        'tahunAkhir',
        'availableYears'
    ));
}


}
