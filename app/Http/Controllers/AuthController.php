<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function dologin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {

            $request->session()->regenerate();

            $userRole = auth()->user()->role_id;

            // Lakukan penyesuaian berdasarkan peran (role) pengguna
            switch ($userRole) {
                case 1:
                    // Jika user adalah admin
                    return redirect()->intended('/admin');
                    break;
                case 2:
                    // Jika user adalah pelapor
                    return redirect()->intended('/pelapor');
                    break;
                case 3:
                    // Jika user adalah surveyor
                    return redirect()->intended('/surveyor');
                    break;
                case 4:
                    // Jika user adalah kabid
                    return redirect()->intended('/kabid');
                    break;
                default:
                    // Tindakan default jika peran (role) tidak cocok
                    return redirect()->intended('/');
                    break;
            }
        }

        // jika email atau password salah
        // kirimkan session error
        return back()->with('error', 'email atau password salah');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
