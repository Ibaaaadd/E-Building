<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use App\Models\Aspek;
use App\Models\Detail;
use App\Models\Indikator;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;

class DetailPenilaianController extends Controller
{
    public function index($id)
    {
        $aspeks = Aspek::all();
        return view('penilaian.index', [
            'aspeks' => $aspeks,
            'id_detail' => $id,
        ]);
    }

    public function simpan(Request $request, $id)
    {
        $index = 0;
        foreach ($request->indikator_id as $key => $value) {
            if ($request->hasFile('gambar_sebelum')) {
                $image = $request->file('gambar_sebelum')[$index];
                $imageName = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('fotoDetail'), $imageName);
            } else {
                // Jika file gambar belum diunggah atau tidak valid
                return redirect()->back()->with('error', 'Foto belum diisi');
            }

            $detailPenilaian = DetailPenilaian::create([
                'id_detail' => $id,
                'id_indikator' => $request->indikator_id[$index],
                'nilai_indikator' => $request->nilai[$index],
                'gambar_sebelum' => $imageName,
            ]);

            $index++;
        }

        $detail = Detail::find($id);

        return redirect()->route('detail.index', $detail->id_pelaporan)->with('success', 'Pelaporan berhasil dibuat.');
    }


    public function detail($id)
    {
        $detailPenilaian  = DetailPenilaian::where('id_detail', $id)->get();
        return view('detail-Penilaian.index', [
            'detailPenilaians' => $detailPenilaian,
            'dtl' => Detail::find($id),
            'jumlahindikator' => Indikator::count()
        ]);
    }

    public function update(Request $request, $id)
    {
        $detailPenilaian = DetailPenilaian::findOrFail($id);

        // Validasi request
        $request->validate([
            'nilai_survey' => 'required|numeric|between:1,5', // Validasi nilai survei
            'gambar_survey' => 'sometimes|image|max:2048',   // Validasi untuk gambar
        ]);

        // Proses upload gambar survey
        if ($request->hasFile('gambar_survey')) {
            $gambarSurvey = $request->file('gambar_survey');
            $imageNameSurvey = time() . '.' . $gambarSurvey->getClientOriginalName();
            $gambarSurvey->move(public_path('fotoDetail'), $imageNameSurvey);

            // Update nama gambar survey di database
            $detailPenilaian->gambar_survey = $imageNameSurvey;
        }

        // Tambahkan nilai survey ke dalam database
        $detailPenilaian->nilai_survey = $request->input('nilai_survey');
        $detailPenilaian->id_surveyor = Auth::user()->id;

        $detailPenilaian->save();

        return redirect()->back()->with('success', 'Detail penilaian berhasil diperbarui.');
    }


    public function upload(Request $request, $id)
    {
        $detailPenilaian = DetailPenilaian::findOrFail($id);

        $request->validate([
            'nilai_sesudah' => 'required|numeric', // Atur validasi sesuai kebutuhan
            'gambar_sesudah' => 'sometimes|image|max:2048', // Optional: tambahkan validasi untuk gambar
        ]);

        // Proses upload gambar sesudah
        if ($request->hasFile('gambar_sesudah')) {
            $gambarSesudah = $request->file('gambar_sesudah');
            $imageNameSesudah = time() . '.' . $gambarSesudah->getClientOriginalName();
            $gambarSesudah->move(public_path('fotoDetail'), $imageNameSesudah);

            // Update nama gambar sesudah di database
            $detailPenilaian->gambar_sesudah = $imageNameSesudah;
        }

        // Tambahkan nilai survey ke dalam database
        $detailPenilaian->nilai_sesudah = $request->input('nilai_sesudah');
        $detailPenilaian->id_surveyor = Auth::user()->id;

        $detailPenilaian->save();

        return redirect()->back()->with('success', 'Detail penilaian berhasil diperbarui.');
    }

    public function ganti(Request $request, $id)
    {
        $detailPenilaian = DetailPenilaian::findOrFail($id);


        // Proses upload gambar sebelum
        if ($request->hasFile('gambar_sebelum')) {
            $gambarSebelum = $request->file('gambar_sebelum');
            $imageNameSebelum = time() . '.' . $gambarSebelum->getClientOriginalName();
            $gambarSebelum->move(public_path('fotoDetail'), $imageNameSebelum);

            // Update nama gambar sebelum di database
            $detailPenilaian->gambar_sebelum = $imageNameSebelum;
        }

        $detailPenilaian->save();

        return redirect()->back()->with('success', 'Detail penilaian berhasil diperbarui.');
    }
}
