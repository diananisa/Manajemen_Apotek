<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\StokProduk;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function dashboardApotekerData()
    {
        $today = Carbon::today();

        $stokKadaluarsa = $this->getStokKadaluarsa($today, false);
        $stokJumlah = $this->getStok();

        return [
            'tanggalFilter'   => $today->toDateString(),
            'produkAktif'     => StokProduk::where('Jumlah', '>', 0)->count(),
            'stokMenipis'     => StokProduk::whereBetween('Jumlah', [1, 50])->count(),
            'chartData'       => [
                'Aman'               => $stokKadaluarsa->where('status', 'Aman')->count(),
                'Hampir Kadaluarsa'  => $stokKadaluarsa->where('status', 'Hampir Kadaluarsa')->count(),
                'Kadaluarsa'         => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
            ],
            'stokChart'       => [
                'Habis'        => $stokJumlah->where('status', 'Habis')->count(),
                'Hampir Habis' => $stokJumlah->where('status', 'Hampir Habis')->count(),
                'Menipis'      => $stokJumlah->where('status', 'Menipis')->count(),
                'Banyak'       => $stokJumlah->where('status', 'Banyak')->count(),
            ],
            'obatKadaluarsa'  => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
            'stokKadaluarsa'  => $stokKadaluarsa,
            'supplierAktif'   => Supplier::where('status', 'Aktif')->count(),
            'supplierNonaktif'=> Supplier::where('status', 'Tidak Aktif')->count(),
            'stok'            => $stokJumlah,
        ];
    }

    public function dashboardApotekerForManagerData()
    {
        $today = Carbon::today();

        $stokKadaluarsa = $this->getStokKadaluarsa($today, true); // semua stok, termasuk 0
        $stokJumlah = $this->getStok(); // status stok

        // Gabungkan data kadaluarsa & stok
        $stokGabungan = $stokJumlah->map(function ($item) use ($stokKadaluarsa) {
            $kadaluarsaInfo = $stokKadaluarsa->firstWhere('Id_Obat', $item->Id_Obat);

            if ($kadaluarsaInfo) {
                $item->status = $kadaluarsaInfo->status;
                $item->badge = $kadaluarsaInfo->badge;
                $item->sisa_hari = $kadaluarsaInfo->sisa_hari;
            } else {
                $item->status = null;
                $item->badge = null;
                $item->sisa_hari = null;
            }
            return $item;
        });

        return [
            'tanggalFilter'   => $today->toDateString(),
            'chartData'       => [
                'Aman'               => $stokKadaluarsa->where('status', 'Aman')->count(),
                'Hampir Kadaluarsa'  => $stokKadaluarsa->where('status', 'Hampir Kadaluarsa')->count(),
                'Kadaluarsa'         => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
            ],
            'stokChart'       => [
                'Habis'        => $stokJumlah->where('status_stok', 'Habis')->count(),
                'Hampir Habis' => $stokJumlah->where('status_stok', 'Hampir Habis')->count(),
                'Menipis'      => $stokJumlah->where('status_stok', 'Menipis')->count(),
                'Banyak'       => $stokJumlah->where('status_stok', 'Banyak')->count(),
            ],
            'obatKadaluarsa'  => $stokKadaluarsa->where('status', 'Kadaluarsa')->count(),
            'stokKadaluarsa'  => $stokKadaluarsa,
            'stok'            => $stokGabungan, // sudah gabungan stok + kadaluarsa
        ];
    }

    public function dashboardKasirData(Request $request)
    {
        $filter     = $request->input('filter', 'bulan');
        $tahun      = $request->input('tahun', now()->year);
        $bulan      = $request->input('bulan', now()->month);
        $tanggal    = $request->input('tanggal', now()->toDateString());
        $tahunMulai = $request->input('tahun_mulai');
        $tahunAkhir = $request->input('tahun_akhir');

        $availableYears = $this->getAvailableYears();

        $salesData = $this->getSalesData(
            $filter, $tahun, $bulan, $tanggal, $tahunMulai, $tahunAkhir, $availableYears
        );

        return [
            'salesData'     => $salesData,
            'filter'        => $filter,
            'tahun'         => $tahun,
            'bulan'         => $bulan,
            'tanggal'       => $tanggal,
            'tahunMulai'    => $tahunMulai,
            'tahunAkhir'    => $tahunAkhir,
            'availableYears'=> $availableYears,
        ];
    }

    public function dashboardApoteker(Request $request)
    {
        return view('dashboard_apoteker', $this->dashboardApotekerData());
    }

    public function dashboardKasir(Request $request)
    {
        return view('dashboard_kasir', $this->dashboardKasirData($request));
    }

    public function dashboardManager(Request $request)
    {
        return view('dashboard_manager', array_merge(
            $this->dashboardKasirData($request),
            $this->dashboardApotekerForManagerData()
        ));
    }

    private function getStokKadaluarsa(Carbon $today, $includeEmpty = false)
    {
        $next7Days = $today->copy()->addDays(7);

        $query = StokProduk::query();

        // Kalau $includeEmpty == false → hanya ambil stok > 0
        if (!$includeEmpty) {
            $query->where('Jumlah', '>', 0);
        }
        
        return $query->get()->map(function ($item) use ($today, $next7Days)
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
                $item->status_stok = 'Habis';
                $item->badge_stok = 'dark';
            } elseif ($item->Jumlah <= 10) {
                $item->status = 'Hampir Habis';
                $item->badge = 'danger';
                $item->status_stok = 'Hampir Habis';
                $item->badge_stok = 'danger';
            } elseif ($item->Jumlah <= 50) {
                $item->status = 'Menipis';
                $item->badge = 'warning';
                $item->status_stok = 'Menipis';
                $item->badge_stok = 'warning';
            } else {
                $item->status = 'Banyak';
                $item->badge = 'success';
                $item->status_stok = 'Banyak';
                $item->badge_stok = 'success';
            }

            return $item;
        });
    }

    private function getAvailableYears()
    {
        return DB::table('transactions')
            ->selectRaw('DISTINCT YEAR(Tanggal_Transaksi) as tahun')
            ->orderBy('tahun', 'asc')
            ->pluck('tahun');
    }

    private function getSalesData($filter, $tahun, $bulan, $tanggal, $tahunMulai, $tahunAkhir, $availableYears)
    {
        switch ($filter) {
            case 'tahun':
                return $this->getYearlyData($tahunMulai, $tahunAkhir, $availableYears);
            case 'bulan':
                return $this->getMonthlyData($tahun);
            case 'hari':
                return $this->getDailyData($tahun, $bulan);
            case 'jam':
                return $this->getHourlyData($tanggal);
            default:
                return collect(); // fallback kosong
        }
    }

    private function getYearlyData($tahunMulai, $tahunAkhir, $availableYears)
    {
        $query = DB::table('transactions')
            ->selectRaw('YEAR(Tanggal_Transaksi) as label, SUM(Total) as total_penjualan')
            ->groupByRaw('YEAR(Tanggal_Transaksi)')
            ->orderByRaw('YEAR(Tanggal_Transaksi)');

        if (count($availableYears) > 3 && $tahunMulai && $tahunAkhir) {
            $query->whereBetween(DB::raw('YEAR(Tanggal_Transaksi)'), [$tahunMulai, $tahunAkhir]);
        }

        return $query->get();
    }

    private function getMonthlyData($tahun)
    {
        return DB::table('transactions')
            ->selectRaw('MONTH(Tanggal_Transaksi) as bulan_num, MONTHNAME(Tanggal_Transaksi) as label, SUM(Total) as total_penjualan')
            ->whereYear('Tanggal_Transaksi', $tahun)
            ->groupByRaw('MONTH(Tanggal_Transaksi), MONTHNAME(Tanggal_Transaksi)')
            ->orderByRaw('bulan_num')
            ->get();
    }

    private function getDailyData($tahun, $bulan)
    {
        return DB::table('transactions')
            ->selectRaw('DAY(Tanggal_Transaksi) as hari_num, CONCAT(LPAD(DAY(Tanggal_Transaksi), 2, "0"), " ", MONTHNAME(Tanggal_Transaksi)) as label, SUM(Total) as total_penjualan')
            ->whereYear('Tanggal_Transaksi', $tahun)
            ->whereMonth('Tanggal_Transaksi', $bulan)
            ->groupByRaw('DAY(Tanggal_Transaksi), CONCAT(LPAD(DAY(Tanggal_Transaksi), 2, "0"), " ", MONTHNAME(Tanggal_Transaksi))')
            ->orderByRaw('hari_num')
            ->get();
    }

    private function getHourlyData($tanggal)
    {
        return DB::table('transactions')
            ->selectRaw('HOUR(Tanggal_Transaksi) as jam_num, CONCAT(LPAD(HOUR(Tanggal_Transaksi), 2, "0"), ":00") as label, SUM(Total) as total_penjualan')
            ->whereDate('Tanggal_Transaksi', $tanggal)
            ->groupByRaw('HOUR(Tanggal_Transaksi), CONCAT(LPAD(HOUR(Tanggal_Transaksi), 2, "0"), ":00")')
            ->orderByRaw('jam_num')
            ->get();
    }

}
