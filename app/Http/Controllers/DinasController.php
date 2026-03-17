<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dinas;
use App\Models\Gedung;

class DinasController extends Controller
{
    // Menampilkan semua data dinas
    public function index()
    {
        $dinas = Dinas::all();
        return view('dinas.index', compact('dinas'));
    }

    // Menyimpan dinas baru ke database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_dinas' => 'required',
        ]);

        Dinas::create($validatedData);
        return redirect()->route('dinas.index')->with('success', 'Dinas berhasil ditambahkan.');
    }

    // Memperbarui data dinas yang ada di database
    public function update(Request $request, $id)
    {
        $dinas = Dinas::findOrFail($id);

        $validatedData = $request->validate([
            'nama_dinas' => 'required',
        ]);

        $dinas->update($validatedData);
        return redirect()->route('dinas.index')->with('success', 'Dinas berhasil diperbarui.');
    }


    // Menghapus dinas dari database
    public function destroy($id)
    {
        $dinas = Dinas::findOrFail($id);
        $dinas->delete();

        return redirect()->route('dinas.index')->with('success', 'Dinas berhasil dihapus.');
    }
}
