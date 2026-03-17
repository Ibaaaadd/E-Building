<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspek;
use Termwind\Components\Dd;

class AspekController extends Controller
{
    public function index()
    {
        $aspeks = Aspek::all();
        foreach ($aspeks as $key => $value) {
            foreach ($value->indikator as $k => $v) {
            }
        }
        return view('aspek.index', compact('aspeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_aspek' => 'required',
        ]);

        Aspek::create($request->all());

        return redirect()->route('aspek.index')
            ->with('success', 'Aspek berhasil dibuat.');
    }

    public function update(Request $request, Aspek $aspek)
    {
        $request->validate([
            'nama_aspek' => 'required',
        ]);

        $aspek->update($request->all());

        return redirect()->route('aspek.index')->with('success', 'Edit aspek berhasil.');
    }

    public function destroy(Aspek $aspek)
    {
        $aspek->delete();

        return redirect()->route('aspek.index');
    }
}
