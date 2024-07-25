<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Cities;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
    {
        $agendas = Agendas::all();
        $cities = Cities::all();
        $programs = Programs::all();

        $months = [];
        foreach ($agendas as $agenda) {
            $startMonthA = date('F', strtotime($this->convertToYMD($agenda->start_dt_a)));
            $endMonthA = date('F', strtotime($this->convertToYMD($agenda->end_dt_a)));
            $startMonthR = date('F', strtotime($this->convertToYMD($agenda->start_dt_r)));
            $endMonthR = date('F', strtotime($this->convertToYMD($agenda->end_dt_r)));
            $this->addMonth($months, $startMonthA);
            $this->addMonth($months, $endMonthA);
            $this->addMonth($months, $startMonthR);
            $this->addMonth($months, $endMonthR);
        }

        return view('dashboard.pages.resources.pages.chart', compact('agendas', 'cities', 'programs', 'months'));
    }

    private function addMonth(&$months, $month)
    {
        if (!in_array($month, $months)) {
            $months[] = $month;
        }
    }

    private function convertToYMD($date)
    {
        $dateTime = \DateTime::createFromFormat('m/d/Y', $date);
        return $dateTime ? $dateTime->format('Y-m-d') : null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_a' => 'required|integer',
            'duration_r' => 'required|integer',
            'start_dt_a' => 'required|date_format:m/d/Y',
            'end_dt_a' => 'required|date_format:m/d/Y',
            'start_dt_r' => 'required|date_format:m/d/Y',
            'end_dt_r' => 'required|date_format:m/d/Y',
            'city_id' => 'required|integer|exists:cities,id',
            'program_id' => 'required|integer|exists:programs,id',
        ]);

        Agendas::create([
            'title' => $request->title,
            'duration_a' => $request->duration_a,
            'duration_r' => $request->duration_r,
            'created_by' => Auth::user()->name,
            'start_dt_a' => $this->convertToYMD($request->start_dt_a),
            'end_dt_a' => $this->convertToYMD($request->end_dt_a),
            'start_dt_r' => $this->convertToYMD($request->start_dt_r),
            'end_dt_r' => $this->convertToYMD($request->end_dt_r),
            'city_id' => $request->city_id,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('dashboard.chart')->with('success', 'Agenda berhasil ditambahkan.');
    }
}
