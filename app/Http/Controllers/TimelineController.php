<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Cities;
use App\Models\Programs;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendas::query();

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $agendas = $query->paginate(10);
        $cities = Cities::all();
        $programs = Programs::all();

        return view('dashboard.pages.resources.pages.timeline', compact('agendas', 'cities', 'programs'));
    }

    public function addInformation(Request $request, $id)
    {
        $agenda = Agendas::findOrFail($id);
        $agenda->information = $request->input('keterangan');
        $agenda->save();

        toastr()->success('Berhasil menambahkan keterangan');

        return redirect()->route('dashboard.timeline');
    }
    public function getCitiesByProgram($programId)
    {
        $program = Programs::find($programId);

        if (!$program) {
            return response()->json(['error' => 'Program not found'], 404);
        }

        $cityId = $program->city_id;

        $city = Cities::find($cityId);

        return response()->json($city);
    }
    public function getAllCities()
    {
        $cities = Cities::all(); // Ambil semua kota dari model City
        return response()->json($cities);
    }
}
