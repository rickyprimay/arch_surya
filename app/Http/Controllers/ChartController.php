<?php 

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Cities;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChartController extends Controller
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

        $months = [];
        foreach ($agendas as $agenda) {
            $startMonthA = date('F', strtotime($agenda->start_dt_a));
            $endMonthA = date('F', strtotime($agenda->end_dt_a));
            $startMonthR = date('F', strtotime($agenda->start_dt_r));
            $endMonthR = date('F', strtotime($agenda->end_dt_r));
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_dt_r' => 'required|date_format:m/d/Y',
            'end_dt_r' => 'required|date_format:m/d/Y',
            'city_id' => 'required|integer|exists:cities,id',
            'program_id' => 'required|integer|exists:programs,id',
        ]);

        $start_dt_r = Carbon::createFromFormat('m/d/Y', $request->start_dt_r)->format('Y-m-d');
        $end_dt_r = Carbon::createFromFormat('m/d/Y', $request->end_dt_r)->format('Y-m-d');

        $start_date = Carbon::createFromFormat('Y-m-d', $start_dt_r);
        $end_date = Carbon::createFromFormat('Y-m-d', $end_dt_r);
        $duration_r = $start_date->diffInDays($end_date) + 1;

        Agendas::create([
            'title' => $request->title,
            'duration_r' => $duration_r,
            'created_by' => Auth::user()->name,
            'start_dt_r' => $start_dt_r,
            'end_dt_r' => $end_dt_r,
            'city_id' => $request->city_id,
            'program_id' => $request->program_id,
        ]);

        toastr()->success('Agenda Berhasil di tambahkan');

        return redirect()->route('dashboard.chart');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'start_dt_a' => 'required|date_format:m/d/Y',
            'end_dt_a' => 'required|date_format:m/d/Y',
        ]);

        $agenda = Agendas::findOrFail($id);

        $start_dt_a = Carbon::createFromFormat('m/d/Y', $validated['start_dt_a'])->format('Y-m-d');
        $end_dt_a = Carbon::createFromFormat('m/d/Y', $validated['end_dt_a'])->format('Y-m-d');

        $start_date = Carbon::createFromFormat('Y-m-d', $start_dt_a);
        $end_date = Carbon::createFromFormat('Y-m-d', $end_dt_a);
        $duration_a = $start_date->diffInDays($end_date);

        $agenda->update([
            'start_dt_a' => $start_dt_a,
            'end_dt_a' => $end_dt_a,
            'duration_a' => $duration_a,
        ]);

        toastr()->success('Actual berhasil diperbarui');

        return redirect()->route('dashboard.chart');
    }
}
