<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;

class PresensiController extends Controller
{
    // Menampilkan data presensi, dengan fitur pencarian
    public function index(Request $request)
    {
        $query = Presensi::query();

        // Filter search username (opsional)
        if ($request->filled('search')) {
            $query->where('Username', 'like', '%' . $request->search . '%');
        }

        // Filter tipe bulanan atau harian (default harian)
        $tipe = $request->input('tipe', 'harian');
        $tanggal = $request->input('tanggal', now()->toDateString());

        if ($tipe === 'bulanan') {
            $carbonTanggal = Carbon::parse($tanggal);
            $query->whereYear('tanggal', $carbonTanggal->year)
                ->whereMonth('tanggal', $carbonTanggal->month);
        } else {
            // harian atau default
            $query->whereDate('tanggal', $tanggal);
        }

        $presensis = $query->orderBy('tanggal', 'desc')
                        ->orderBy('jam', 'desc')
                        ->get();

        return view('Presensi.index', compact('presensis'));
    }


    // Menyimpan presensi
    public function store(Request $request)
    {
        $username = session('Username');

        if (!$username) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $today = Carbon::today();
        $role = session('role'); // Ambil role dari session

        // Cek apakah user sudah presensi hari ini
        $cekPresensi = Presensi::where('Username', $username)
                            ->whereDate('tanggal', $today)
                            ->first();

        if ($cekPresensi) {

            $cekPresensi->update([
                'status_kehadiran' => 'Hadir',
                'jam' => now()->format('H:i:s'),
                'role' => $role
            ]);

            // Kalau sudah presensi → arahkan ke halaman "sudah presensi" sesuai role
            if ($role === 'Kasir') {
                return redirect()->route('Presensi.kasir.sudah')
                                ->with('message', 'Anda sudah melakukan presensi hari ini.');
            } elseif ($role === 'Apoteker') {
                return redirect()->route('Presensi.apoteker.sudah')
                                ->with('message', 'Anda sudah melakukan presensi hari ini.');
            } else {
                return redirect()->route('Presensi.sudah')
                                ->with('message', 'Anda sudah melakukan presensi hari ini.');
            }
        }

        // Simpan presensi baru
        Presensi::create([
            'Username'          => $username,
            'tanggal'           => Carbon::now()->toDateString(),
            'jam'               => Carbon::now()->format('H:i:s'),
            'status_kehadiran'  => 'Hadir',
            'role'              => $role,
        ]);
    }

    // Menampilkan rekap presensi
    public function rekap(Request $request)
    {
        $tipe = $request->input('tipe', 'harian');
        $tanggal = $request->input('tanggal', now()->toDateString());

        $userQuery = User::query();

        if ($request->filled('search')) {
            $userQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $userQuery->get();
        $presensis = Presensi::whereDate('tanggal', $tanggal)->get()->keyBy('Username');

        return view('Presensi.rekap', compact('users', 'presensis', 'tanggal', 'tipe'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:presensis,id',
            'status' => 'required|in:Hadir,Tidak Hadir,Izin',
        ]);

        $presensi = Presensi::findOrFail($request->id);
        $presensi->status_kehadiran = $request->status;
        $presensi->save();

        return response()->json([
            'success' => true,
            'message' => 'Status presensi berhasil diperbarui.'
        ]);
    }

    public function cekStatusHariIni()
    {
        $username = session('Username');

        if (!$username) {
            return 'Belum Login';
        }

        $today = Carbon::today()->toDateString();

        $presensi = Presensi::where('Username', $username)
            ->whereDate('tanggal', $today)
            ->first();

        return $presensi ? $presensi->status_kehadiran : null;
    }

}
