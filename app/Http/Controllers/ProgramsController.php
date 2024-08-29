<?php 

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Division;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramsController extends Controller
{
    public function index(Request $request)
    {
        $division_id = $request->input('division_id');
        $city_id = $request->input('city_id');

        $query = Programs::query();

        if ($division_id) {
            $query->where('division_id', $division_id);
        }

        if ($city_id) {
            $query->where('city_id', $city_id);
        }

        $programs = $query->with('city', 'division')->get();
        $cities = Cities::all();
        $division = Division::all();

        return view('dashboard.pages.resources.pages.programs', compact('programs', 'cities', 'division'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required|integer|exists:divisions,id',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        Programs::create([
            'name' => $request->name,
            'division_id' => $request->division_id,
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
            'division_id' => 'required|integer|exists:divisions,id',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        $program = Programs::findOrFail($id);
        $program->update([
            'name' => $request->name,
            'division_id' => $request->division_id,
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
