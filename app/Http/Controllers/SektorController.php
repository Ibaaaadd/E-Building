<?php

namespace App\Http\Controllers;

use App\Models\Sektor;
use Illuminate\Http\Request;

class SektorController extends Controller
{
    public function index()
    {
        $sektor = Sektor::all();
        return view('sektor.index', compact('sektor'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'detail' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('fotoSektor'), $imageName);
            $validatedData['foto'] = $imageName;
        }

        Sektor::create($validatedData);

        return redirect()->route('sektor.index')->with('success', 'Sektor berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $sektor = Sektor::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'detail' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('fotoSektor'), $imageName);
            $validatedData['foto'] = $imageName;
        } else {
            $validatedData['foto'] = $sektor->foto; // Keep existing photo if no new photo is uploaded
        }

        $sektor->update($validatedData);

        return redirect()->route('sektor.index')->with('success', 'Sektor berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $sektor = Sektor::findOrFail($id);
        if (file_exists(public_path('fotoSektor/' . $sektor->foto))) {
            unlink(public_path('fotoSektor/' . $sektor->foto));
        }
        $sektor->delete();

        return redirect()->route('sektor.index')->with('success', 'Sektor berhasil dihapus.');
    }
}
