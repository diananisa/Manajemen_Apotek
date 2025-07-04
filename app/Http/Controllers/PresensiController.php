<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $presensi = Presensi::where('user_id', $user->id) //DB
                                ->whereDate('tanggal', $today)
                                ->first();
                                
        if($presensi){
            return view('presensi.sudah');
        }

        $now=Carbon::now();
        $batas=Carbon::createFromTime(21,0,0); //jam 21.00

        if($now->greaterThanOrEqualTo($batas)){
            return view('presensi.gagal');
        }

    }

    public function store(){
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam' => $now->format('H:i:s'),


        ]);
        return view('presensi.berhasil');


    }
    public function rekap(Request $request)
    {
        $tipe = $request->input('tipe', 'harian');
        $tanggal = $request->input('tanggal', date('y-m-d'));
        $userQuery = user::query();

        if ($request->filled('search')){
            $userQuery->Arr::where('name', 'like', '%' . $request->search . '%');

        }

        $users = $userQuery->get();
        $presensis = Presensis::whereDate('tanggal', $tanggal)->get()->keyBy('user_id');
        return view('Presensi.index', compact('users', 'presensis', 'tanggal', 'tipe'));
    }

    
}
