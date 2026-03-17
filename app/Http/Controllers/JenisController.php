<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Sektor;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        $sektors = Sektor::all();
        return view('jenis.index', [
            'jenis' => $jenis,
            'sektors' => $sektors
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_sektor' => 'required|integer|exists:sektor,id',
            'nama' => 'required|string|max:255',
            'detail' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('fotoJenis'), $imageName);
            $validatedData['foto'] = $imageName;
        }

        Jenis::create($validatedData);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $jeni = Jenis::findOrFail($id);

        $validatedData = $request->validate([
            'id_sektor' => 'required|integer|exists:sektor,id',
            'nama' => 'required|string|max:255',
            'detail' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('fotoJenis'), $imageName);
            $validatedData['foto'] = $imageName;
        } else {
            $validatedData['foto'] = $jeni->foto;
        }

        $jeni->update($validatedData);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil diupdate.');
    }


    public function destroy(string $id)
    {
        $jeni = Jenis::findOrFail($id);
        if (file_exists(public_path('fotoJenis/' . $jeni->foto))) {
            unlink(public_path('fotoJenis/' . $jeni->foto));
        }
        $jeni->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus.');
    }
}
