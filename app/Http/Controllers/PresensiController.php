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

        if ($request->has('search')) {
            $query->where('Username', 'like', '%' . $request->search . '%');
        }

        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $presensis = $query->get();

        return view('presensi.index', compact('presensis'));
    }

    // Menyimpan presensi
    public function store(Request $request)
    {
        $username = session('Username'); // pakai helper session()

        if (!$username) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $today = Carbon::today();

        // Cek apakah user sudah presensi hari ini
        $cekPresensi = Presensi::where('Username', $username)
                               ->whereDate('tanggal', $today)
                               ->first();

        if ($cekPresensi) {
            return redirect()->route('presensi.sudah')->with('message', 'Anda sudah melakukan presensi hari ini.');
        }

        // Simpan presensi
        Presensi::create([
            'Username' => $username,
            'tanggal' => Carbon::now()->toDateString(), 
            'jam'     => Carbon::now()->format('H:i:s'),
        ]);

        // return redirect()->route('presensi.berhasil')->with('message', 'Presensi berhasil dilakukan.');
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

        return view('presensi.rekap', compact('users', 'presensis', 'tanggal', 'tipe'));
    }
}
