<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indikator;
use App\Models\Aspek;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikators = Indikator::all();
        $aspeks = Aspek::all();
        return view('indikator.index', compact('indikators', 'aspeks'));
    }

    public function create()
    {
        $aspeks = Aspek::all();
        return view('indikator.create', compact('aspeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_aspek' => 'required|exists:aspek,id',
            'nama_indikator' => 'required|string|max:255',
        ]);

        Indikator::create($request->all());

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function edit(Indikator $indikator)
    {
        $aspeks = Aspek::all();
        return view('indikator.edit', compact('indikator', 'aspeks'));
    }

    public function update(Request $request, Indikator $indikator)
    {
        $request->validate([
            'id_aspek' => 'required|exists:aspek,id',
            'nama_indikator' => 'required|string|max:255',
        ]);

        $indikator->update($request->all());

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil diperbarui');
    }

    public function destroy(Indikator $indikator)
    {
        $indikator->delete();

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil dihapus');
    }
}
