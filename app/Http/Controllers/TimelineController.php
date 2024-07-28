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

        $agendas = $query->get();
        $cities = Cities::all();
        $programs = Programs::all();

        return view('dashboard.pages.resources.pages.timeline', compact('agendas', 'cities', 'programs'));
    }
}
