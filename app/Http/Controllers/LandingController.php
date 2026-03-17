<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Jenis;
use App\Models\Sektor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request) {
        $data = Sektor::all();
        $data_title = 'Seluruh Bangunan';
        $view = 'landing.index';
        return view('landing.index', compact('data', 'data_title'));
    }
    public function sektor(Request $request, $id) {
        // $id = $request->sektor;
        $sektor = Sektor::find($id);
        $data = Jenis::where('id_sektor', $id)->get();
        $data_title = 'Sektor '.$sektor->nama;
        return view('landing.index-sektor', compact('data', 'data_title'));
    }

    public function jenis(Request $request, $id) {
        // $id = $request->jenis;
        $jenis = Jenis::find($id);
        $data = Gedung::where('id_jenis', $id)->get();
        $data_title = 'Jenis '.$jenis->nama;
        return view('landing.index-jenis', compact('data', 'data_title'));
    }

    public function gedung(Request $request, $id) {
        // $id = $request->gedung;
        $gedung = Gedung::find($id);
        return view('landing.index-gedung', compact('gedung'));
    }
}
