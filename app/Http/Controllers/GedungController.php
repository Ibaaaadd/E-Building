<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Gedung;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GedungController extends Controller
{
    public function index()
    {
        $dinas = Dinas::all();
        $jenis = Jenis::all();
        $gedungs = Gedung::all();
        return view('gedung.index', compact('gedungs'));
    }

    public function create()
    {
        $dinas = Dinas::all();
        $jenis = Jenis::all();
        return view('gedung.create', compact('dinas','jenis'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dinas' => 'required|string',
            'id_jenis' => 'required|string',
            'nama_gedung' => 'required|string',
            'alamat_gedung' => 'required|string',
            'foto_gedung' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
            'luas_gedung' => 'required|integer',
            'luas_tanah' => 'required|integer',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        // Penanganan unggahan foto
        if ($request->hasFile('foto_gedung')) {
            $image = $request->file('foto_gedung');
            $imageName = time() . '.' . $image->extension(); // Atur nama file unik
            $image->move(public_path('fotoGedung'), $imageName); // Pindahkan file ke direktori yang ditentukan
            $validatedData['foto_gedung'] = $imageName; // Simpan nama file ke dalam data yang akan disimpan
        }

        $validatedData['id_user'] = Auth::user()->id;
        Gedung::create($validatedData);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil ditambahkan.');
    }


    public function edit(Gedung $gedung)
    {
        $jenis = Jenis::all();
        $dinas = Dinas::all();
        return view('gedung.edit', compact('gedung', 'dinas', 'jenis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_dinas' => 'required|string',
            'id_jenis' => 'required|string',
            'nama_gedung' => 'required|string',
            'alamat_gedung' => 'nullable|string',
            'foto_gedung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'luas_gedung' => 'required|integer',
            'luas_tanah' => 'required|integer',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        $gedung = Gedung::findOrFail($id);

        // Periksa apakah ada file foto baru yang diunggah
        if ($request->hasFile('foto_gedung')) {
            // Hapus foto lama jika ada
            if ($gedung->foto_gedung) {
                unlink(public_path('fotoGedung/' . $gedung->foto_gedung));
            }
            // Unggah foto baru
            $image = $request->file('foto_gedung');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('fotoGedung'), $imageName);
            $validatedData['foto_gedung'] = $imageName;
        }

        $validatedData['id_user'] = Auth::user()->id;
        $gedung->update($validatedData);

        return redirect()->route('gedung.index')->with('success', 'Data gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
