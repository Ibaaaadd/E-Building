<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Dinas;
use App\Models\Sektor;
use App\Models\Gedung;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mengambil informasi pengguna saat ini

        if ($user->role_id == 2) {
            $pelaporans = Pelaporan::where('id_user', $user->id)->count();
            $pelaporansselesai = Detail::where('id_user', $user->id)->where('status', 4)->count();
            $menunggu = Detail::where('id_user', $user->id)->where('status', 0)->count();
            $survey = Detail::where('id_user', $user->id)->where('status', 1)->count();
            $acc = Detail::where('id_user', $user->id)->where('status', 3)->count();
            $tolak = Detail::where('id_user', $user->id)->where('status', -1)->count();
        } else {
            $pelaporans = Pelaporan::count();
            $pelaporansselesai = Detail::where('status', 4)->count();
            $menunggu = Detail::where('status', 0)->count();
            $survey = Detail::where('status', 1)->count();
            $acc = Detail::where('status', 3)->count();
            $tolak = Detail::where('status', -1)->count();
        }

        return view('home', [
            'dtl' => Detail::count(),
            'gedung' => Gedung::count(),
            'pelaporan' => $pelaporans,
            'sektor' => Sektor::count(),
            'dinas' => Dinas::count(),
            'pelaporansselesai' => $pelaporansselesai,
            'menunggu' => $menunggu,
            'survey' => $survey,
            'acc' => $acc,
            'tolak' => $tolak,
            'dns' => Dinas::all(),
            'gedungs' => Gedung::all(),
            'pelaporans' => Pelaporan::all(),
        ]);
    }
}
