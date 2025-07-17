<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use App\Models\User;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('Login.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $today = Carbon::today();

        $presensi = Presensi::where('user_id', $user->id)
                            ->whereDate('tanggal', $today)
                            ->first();
                                
        if ($presensi) {
            return view('presensi.sudah');
        }

        $now = Carbon::now();
        $batas = Carbon::createFromTime(21, 0, 0); // jam 21.00

        if ($now->greaterThanOrEqualTo($batas)) {
            return view('presensi.gagal');
        }

        return view('presensi.belum');
    }

    public function store()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('Login.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $today = Carbon::today();
        $now = Carbon::now();

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam' => $now->format('H:i:s'),
        ]);

        return redirect()->route('presensi.sudah');
    }

    public function rekap(Request $request)
    {
        $tipe = $request->input('tipe', 'harian');
        $tanggal = $request->input('tanggal', date('Y-m-d')); // kapitalisasi Y

        $userQuery = User::query();

        if ($request->filled('search')) {
            $userQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $userQuery->get();
        $presensis = Presensi::whereDate('tanggal', $tanggal)->get()->keyBy('user_id');

        return view('presensi.index', compact('users', 'presensis', 'tanggal', 'tipe'));
    }
}
