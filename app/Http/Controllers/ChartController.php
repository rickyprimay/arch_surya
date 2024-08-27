<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Cities;
use App\Models\LogAgenda;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        $latestAgenda = Agendas::orderBy('start_dt_r', 'desc')->first();
        $latestYear = $latestAgenda ? date('Y', strtotime($latestAgenda->start_dt_r)) : date('Y');
        $latestMonth = $latestAgenda ? date('m', strtotime($latestAgenda->start_dt_r)) : date('m');

        $selectedYear = $request->input('year', $latestYear);
        $selectedMonth = $request->input('month', $latestMonth);

        $query->where(function ($query) use ($selectedYear, $selectedMonth) {
            $query
                ->whereYear('start_dt_r', $selectedYear)
                ->whereMonth('start_dt_r', $selectedMonth)
                ->orWhere(function ($query) use ($selectedYear, $selectedMonth) {
                    $query->whereYear('end_dt_r', $selectedYear)->whereMonth('end_dt_r', $selectedMonth);
                })
                ->orWhere(function ($query) use ($selectedYear, $selectedMonth) {
                    $query->whereYear('start_dt_r', $selectedYear)->whereMonth('start_dt_r', '<', $selectedMonth)->whereYear('end_dt_r', $selectedYear)->whereMonth('end_dt_r', '>', $selectedMonth);
                });
        });

        $agendas = $query->get();
        $cities = Cities::all();
        $programs = Programs::all();

        $years = Agendas::selectRaw('YEAR(start_dt_r) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        $months = range(1, 12);

        $logAgendas = LogAgenda::all();

        $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth)->daysInMonth;

        return view('dashboard.pages.resources.pages.chart', compact('logAgendas', 'agendas', 'cities', 'programs', 'years', 'months', 'selectedYear', 'selectedMonth', 'daysInMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_dt_r' => 'required|date_format:m/d/Y',
            'end_dt_r' => 'required|date_format:m/d/Y',
            'program_id' => 'required|integer|exists:programs,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $city_id = Programs::find($request->program_id)->city_id;

        $start_dt_r = Carbon::createFromFormat('m/d/Y', $request->start_dt_r)->format('Y-m-d');
        $end_dt_r = Carbon::createFromFormat('m/d/Y', $request->end_dt_r)->format('Y-m-d');

        $start_date = Carbon::createFromFormat('Y-m-d', $start_dt_r);
        $end_date = Carbon::createFromFormat('Y-m-d', $end_dt_r);
        $duration_r = $start_date->diffInDays($end_date) + 1;

        $agenda = Agendas::create([
            'title' => $request->title,
            'duration_r' => $duration_r,
            'created_by' => Auth::user()->name,
            'start_dt_r' => $start_dt_r,
            'end_dt_r' => $end_dt_r,
            'city_id' => $city_id,
            'program_id' => $request->program_id,
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('document', 'public');
            $agenda->document = $path;
            $agenda->save();
        }

        LogAgenda::create([
            'name' => Auth::user()->name,
            'status' => 0,
            'title' => $request->title,
        ]);

        toastr()->success('Agenda Berhasil di tambahkan');

        return redirect()->route('dashboard.chart');
    }

    public function updateActual(Request $request, $id)
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
        $duration_a = $start_date->diffInDays($end_date) + 1;
        $updated_actual = Carbon::createFromTimestamp(Carbon::now()->timestamp)->toDateTimeString();

        $agenda->update([
            'start_dt_a' => $start_dt_a,
            'end_dt_a' => $end_dt_a,
            'duration_a' => $duration_a,
            'updated_actual' => $updated_actual,
        ]);

        LogAgenda::create([
            'name' => Auth::user()->name,
            'status' => 1,
            'title' => $agenda->title,
        ]);

        toastr()->success('Actual berhasil diperbarui');

        return redirect()->route('dashboard.chart');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_dt_r' => 'required|date_format:m/d/Y',
            'end_dt_r' => 'required|date_format:m/d/Y',
            'program_id' => 'required|integer|exists:programs,id',
            'start_dt_a' => 'nullable|date_format:m/d/Y',
            'end_dt_a' => 'nullable|date_format:m/d/Y',
            'file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $city_id = Programs::find($validated['program_id'])->city_id;

        $agenda = Agendas::findOrFail($id);

        $start_dt_r = Carbon::createFromFormat('m/d/Y', $validated['start_dt_r'])->format('Y-m-d');
        $end_dt_r = Carbon::createFromFormat('m/d/Y', $validated['end_dt_r'])->format('Y-m-d');

        $start_date_r = Carbon::createFromFormat('Y-m-d', $start_dt_r);
        $end_date_r = Carbon::createFromFormat('Y-m-d', $end_dt_r);
        $duration_r = $start_date_r->diffInDays($end_date_r) + 1;

        $agenda->update([
            'title' => $validated['title'],
            'start_dt_r' => $start_dt_r,
            'end_dt_r' => $end_dt_r,
            'duration_r' => $duration_r,
            'city_id' => $city_id,
            'program_id' => $validated['program_id'],
        ]);

        if ($request->hasFile('file')) {
            if ($agenda->document) {
                Storage::disk('public')->delete($agenda->document);
            }

            $path = $request->file('file')->store('document', 'public');
            $agenda->document = $path;
            $agenda->save();
        }

        if ($request->filled('start_dt_a') && $request->filled('end_dt_a')) {
            $start_dt_a = Carbon::createFromFormat('m/d/Y', $validated['start_dt_a'])->format('Y-m-d');
            $end_dt_a = Carbon::createFromFormat('m/d/Y', $validated['end_dt_a'])->format('Y-m-d');

            $start_date_a = Carbon::createFromFormat('Y-m-d', $start_dt_a);
            $end_date_a = Carbon::createFromFormat('Y-m-d', $end_dt_a);
            $duration_a = $start_date_a->diffInDays($end_date_a) + 1;

            $agenda->update([
                'start_dt_a' => $start_dt_a,
                'end_dt_a' => $end_dt_a,
                'duration_a' => $duration_a,
            ]);
        }

        LogAgenda::create([
            'name' => Auth::user()->name,
            'status' => 2,
            'title' => $agenda->title,
        ]);

        toastr()->success('Agenda Berhasil diperbarui');

        return redirect()->route('dashboard.chart');
    }

    public function destroy($id)
    {
        $agenda = Agendas::findOrFail($id);
        $agendaTitle = $agenda->title;
        $agenda->delete();

        LogAgenda::create([
            'name' => Auth::user()->name,
            'status' => 3,
            'title' => $agendaTitle,
        ]);

        toastr()->success('Agenda Berhasil dihapus');

        return redirect()->route('dashboard.chart');
    }

    public function getProgramsByYear($year)
    {
        $programs = Programs::whereHas('agendas', function ($query) use ($year) {
            $query->whereYear('start_dt_r', $year);
        })->get();

        return response()->json([
            'programs' => $programs,
        ]);
    }
}
