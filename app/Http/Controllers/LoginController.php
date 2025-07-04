<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'password' => 'required',
        ]);

        // $login = Login::where('Username', $request->Username)->first();

        // if(!$login || $request->password !== $login->password){
        //     return back()->withErrors(['login' => 'Username atau Password salah']);
        // }

        Session::put('Username', $request->Username);

        // Login::create([
        //     'Username' => $login->Username,
        //     'password' => $login->password,

        // ]);
        
        if($request->password == 'Man3291')
        {
            //Session::put('Username', $login->Username);
            Session::put('role', 'Manajer');
            return redirect()->route('dashboard_manager');
        }

        if($request->password == 'Teker4568'){
            //Session::put('Username', $login->Username);
            Session::put('role', 'Apoteker');
            return redirect()->route('dashboard_apoteker');
        }

         if($request->password == 'Ksr1008'){
            //Session::put('Username', $login->Username);
            Session::put('role', 'Kasir');
            return redirect()->route('dashboard_kasir');
        }

        
        // $hariIni = now()->toDateString();
        // $sudahPresensi = Presensi::where('Username', $login->Username)
        //                     ->where('tanggal', $hariIni)
        //                     ->exists();
        // if(!$sudahPresensi){
        //     Presensi::create([
        //         'Username' => $login->Username,
        //         'tanggal' => $hariIni,
        //         'jam' => now()->toTimeString(),
        //     ]);
        // }

        return view('welcome');
    }

    public function logout(){
        Session::forget('Username');
        return redirect()->route('Login.login');
    }
}
