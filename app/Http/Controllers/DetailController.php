<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index($id)
    {
        $details = Detail::where('id_pelaporan', $id)->get();
        return view('detail.index', [
            'details' => $details,
            'id' => $id
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'bidang' => 'required',
        ]);

        $detail = Detail::create([
            'id_pelaporan' => $id,
            'id_user' => Auth::user()->id,
            'bidang' => $request->bidang,
            'status' => 0
        ]);

        return redirect()->route('penilaian.index', $detail->id)
            ->with('success', 'Detail created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bidang' => 'required',
        ]);

        // Mengambil data Detail yang akan diupdate
        $detail = Detail::findOrFail($id);

        // Melakukan update data
        $detail->bidang = $request->bidang;
        $detail->save();

        $pelaporan = Pelaporan::find($id);

        return redirect()->route('detail.index', $detail->id_pelaporan)
            ->with('success', 'Detail updated successfully.');
    }


    public function destroy($id)
    {
        $detail = Detail::find($id);
        if ($detail) {
            $detail->delete();
            return redirect()->route('detail.index', $detail->id_pelaporan)
                ->with('success', 'Detail deleted successfully');
        }
        return redirect()->route('detail.index')
            ->with('error', 'Detail not found');
    }

    public function updateStatus(Request $request, $id)
    {
        $detail = Detail::findOrFail($id);
        $status = $request->input('status');
        $timestampColumn = null;
        $userColumn = null;

        switch ($status) {
            case 1:
                $timestampColumn = 'survey_at';
                $userColumn = 'id_survey_at';
                break;
            case 2:
                $timestampColumn = 'acc_at';
                $userColumn = 'id_acc_at';
                break;
            case -1:
                $timestampColumn = 'tolak_at';
                $userColumn = 'id_tolak_at';
                break;
            case 3:
                $timestampColumn = 'selesai_at';
                $userColumn = 'id_selesai_at';
                break;
        }

        if ($timestampColumn && $userColumn) {
            $detail->update([
                'status' => $status,
                $timestampColumn => now(),
                $userColumn => Auth::user()->id
            ]);
        }

        return back()->with('success', 'Detail status updated successfully.');
    }
}
