<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Gedung;
use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\Dinas;
use App\Models\DetailPenilaian;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;


class PelaporanController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user(); // Mengambil informasi pengguna saat ini

        if ($user->role_id == 2) {
            $pelaporans = Pelaporan::where('id_user', $user->id); // Hanya ambil laporan yang dibuat oleh pengguna saat ini
        } else {
            $pelaporans = Pelaporan::query(); // Menggunakan query baru untuk semua pelaporan
        }

        if ($request->has('status')) {
            $pelaporans->where('status', $request->status); // Filter berdasarkan status jika parameter ada
        }

        $pelaporans = $pelaporans->get();

        $dinas = Dinas::all();
        $gedungs = Gedung::all();
        return view('pelaporan.index', [
            'pelaporans' => $pelaporans,
            'dinas' => $dinas,
            'gedungs' => $gedungs,
        ]);
    }


    public function create()
    {
        $gedungs = Gedung::all();
        $dinas = Dinas::all();
        return view('pelaporan.create', [
            'gedungs' => $gedungs,
            'dinas' => $dinas,
        ]);

        $aspeks = Aspek::all();
        return view('penilaian.index', compact('aspeks'));
    }

    public function store(Request $request)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'id_gedung' => 'required|exists:gedung,id',
            'id_dinas' => 'required|exists:dinas,id',
            'tanggal_laporan' => 'required|date',
            'deskripsi_laporan' => 'required|string',
            'surat' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        // Simpan data pelaporan
        $pelaporan = new Pelaporan();
        $pelaporan->id_user = Auth::user()->id;
        $pelaporan->id_gedung = $validatedData['id_gedung'];
        $pelaporan->id_dinas = $validatedData['id_dinas'];
        $pelaporan->tanggal_laporan = $validatedData['tanggal_laporan'];
        $pelaporan->deskripsi_laporan = $validatedData['deskripsi_laporan'];

        // Upload surat jika ada
        if ($request->hasFile('surat')) {
            $file = $request->file('surat');
            $filename = time() . '_' . $file->getClientOriginalName(); // Membuat nama file unik dengan menambahkan timestamp
            $file->move('fotoSurat', $filename, 'public'); // Menyimpan file dengan nama unik ke folder 'surat'
            $pelaporan->surat = $filename; // Menyimpan nama file ke dalam kolom 'surat'
        }

        $pelaporan->save();

        return redirect()->route('pelaporan.index')
            ->with('Sukses', 'Pelaporan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'deskripsi_laporan' => 'nullable|string',
            'surat' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        // Ambil data pelaporan berdasarkan ID
        $pelaporan = Pelaporan::findOrFail($id);

        if ($request->hasFile('surat')) {
            // Hapus foto lama jika ada
            if ($pelaporan->surat) {
                unlink(public_path('fotoSurat/' . $pelaporan->surat));
            }

            // Unggah foto baru
            $file = $request->file('surat');
            $filename = time() . '.' . $file->extension(); // Membuat nama file unik dengan menambahkan timestamp
            $file->move(public_path('fotoSurat'), $filename); // Menyimpan file dengan nama unik ke folder 'surat'
            $validatedData['surat'] = $filename; // Menyimpan nama file ke dalam kolom 'surat'
        }

        // Update data pelaporan dengan data yang validasi
        $pelaporan->update($validatedData);

        return redirect()->route('pelaporan.index')->with('Sukses', 'Pelaporan berhasil diperbarui.');
    }

    public function destroy(Pelaporan $pelaporan)
    {
        $pelaporan->delete();

        return redirect()->route('pelaporan.index')
            ->with('Sukses', 'Pelaporan berhasil dihapus.');
    }

    // PelaporanController.php
    public function show($id)
    {
        $pelaporan = Pelaporan::with('user')->findOrFail($id);
        return view('pelaporan.show', compact('pelaporan'));
    } 
    
}
