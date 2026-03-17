<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua pengguna

        return view('user.index', compact('users')); // Kirim data pengguna ke view
    }

    public function create()
    {
        // Tampilkan formulir untuk membuat akun baru
        return view('user.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|numeric|in:1,2,3,4', // Memastikan role_id hanya dari 1 sampai 4
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['role_id'],
        ]);

        // Redirect ke halaman yang sesuai berdasarkan role_id yang dibuat
        switch ($validatedData['role_id']) {
            case 1:
                return redirect()->route('user.index')->with('success', 'Akun admin berhasil dibuat.');
                break;
            case 2:
                return redirect()->route('user.index')->with('success', 'Akun pelapor berhasil dibuat.');
                break;
            case 3:
                return redirect()->route('user.index')->with('success', 'Akun surveyor berhasil dibuat.');
                break;
            case 4:
                return redirect()->route('user.index')->with('success', 'Akun kabid berhasil dibuat.');
                break;
            default:
                return redirect()->route('home')->with('error', 'Gagal membuat akun. Peran (role) tidak valid.');
                break;
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|numeric|in:1,2,3,4',
        ]);

        $user->update($validatedData);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus secara lunak.');
    }

    public function show()
    {
        $user = User::onlyTrashed()->get();
        return view('user.show', compact('user'));
    }


    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        return redirect()->route('user.index')->with('success', 'User berhasil dipulihkan.');
    }

    public function delete($id)
    {
        dd('d');
        $user = User::find($id);
        $user->forceDelete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus secara lunak.');
    }
}
