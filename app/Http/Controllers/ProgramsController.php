<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramsController extends Controller
{
    public function index()
    {
        $programs = Programs::with('city')->get();
        $cities = Cities::all();

        return view('dashboard.pages.resources.pages.programs', compact('programs', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        Programs::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'created_by' => Auth::user()->name,
        ]);

        toastr()->success('Program berhasil ditambahkan');
        return redirect()->route('dashboard.programs');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        $program = Programs::findOrFail($id);
        $program->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        toastr()->success('Program berhasil diperbarui');
        return redirect()->route('dashboard.programs');
    }

    public function destroy($id)
    {
        $program = Programs::findOrFail($id);
        $program->delete();

        toastr()->success('Program berhasil dihapus');
        return redirect()->route('dashboard.programs');
    }
}
