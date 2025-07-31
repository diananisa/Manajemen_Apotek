<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->Username;
        $password = $request->password;

        // Simulasi login dengan 3 role default (hardcoded)
        $roles = [
            'Manajer'   => 'Man3291',
            'Apoteker'  => 'Teker4568',
            'Kasir'     => 'Ksr1008',
        ];

        $roleFound = null;
        foreach ($roles as $role => $pw) {
            if ($password === $pw) {
                $roleFound = $role;
                break;
            }
        }

        if ($roleFound === null) {
            return back()->withErrors(['login' => 'Username atau Password salah']);
        }

        // Simpan ke session
        Session::put('Username', $username);
        Session::put('role', $roleFound);

        // Simpan ke database login
        Login::updateOrInsert(
            ['Username' => $username],
            ['password' => $password, 'updated_at' => now()]
        );

        // Simpan presensi jika belum presensi hari ini
        $today = now()->toDateString();
        $sudahPresensi = Presensi::where('Username', $username)
                            ->where('tanggal', $today)
                            ->exists();

        if (!$sudahPresensi) {
            Presensi::create([
                'Username' => $username,
                'tanggal' => $today,
                'jam'     => now()->toTimeString(),
            ]);
        }

        // Redirect sesuai role
        return match ($roleFound) {
            'Manajer'   => redirect()->route('dashboard_manager'),
            'Apoteker'  => redirect()->route('dashboard_apoteker'),
            'Kasir'     => redirect()->route('dashboard_kasir'),
        };
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('Login.login');
    }

    public function showData()
    {
        $logins = Login::all();
        $presensis = Presensi::all();

        return view('login.data', compact('logins', 'presensis'));
    }

    public function authenticate(Request $request)
    {
        $user = Login::where('Username', $request->Username)
                    ->where('password', $request->password)
                    ->first();

        if ($user) {
            session(['Username' => $user->Username, 'role' => $user->role]);
            return redirect()->route('presensi.index');
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah.');
        }
    }   


}
