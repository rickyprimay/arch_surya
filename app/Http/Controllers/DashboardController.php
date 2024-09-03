<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $selectedYear = $request->input('year', date('Y'));

    $totalActual = Agendas::whereYear('start_dt_r', $selectedYear)
                          ->whereNotNull('end_dt_a')
                          ->count();
    $totalPlan = Agendas::whereYear('start_dt_r', $selectedYear)
                        ->whereNull('end_dt_a')
                        ->count();
    $totalOnTime = Agendas::whereYear('start_dt_r', $selectedYear)
                          ->whereNotNull('end_dt_a')
                          ->whereColumn('end_dt_a', '<=', 'end_dt_r')
                          ->count();
    $totalLate = Agendas::whereYear('start_dt_r', $selectedYear)
                        ->whereNotNull('end_dt_a')
                        ->whereColumn('end_dt_a', '>', 'end_dt_r')
                        ->count();

    $years = Agendas::selectRaw('YEAR(start_dt_r) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

    $agendasByYear = Agendas::whereYear('start_dt_r', $selectedYear)
                            ->get()
                            ->groupBy(function($item) {
                                return \Carbon\Carbon::parse($item->start_dt_r)->format('n');
                            });

    $completedData = [];
    $inProgressData = [];
    $onTimeData = [];
    $lateData = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyAgendas = isset($agendasByYear[$i]) ? $agendasByYear[$i] : collect([]);
        $completedData[] = $monthlyAgendas->whereNotNull('end_dt_a')->count();
        $inProgressData[] = $monthlyAgendas->whereNull('end_dt_a')->count();
        $onTimeData[] = $monthlyAgendas->filter(function($agenda) {
            return $agenda->end_dt_a && $agenda->end_dt_a <= $agenda->end_dt_r;
        })->count();
        $lateData[] = $monthlyAgendas->filter(function($agenda) {
            return $agenda->end_dt_a && $agenda->end_dt_a > $agenda->end_dt_r;
        })->count();
    }

    $chartData = [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'datasets' => [
            [
                'label' => 'Telah Selesai',
                'data' => $completedData,
                'backgroundColor' => 'rgba(75, 0, 130, 0.2)',
                'borderColor' => 'rgba(75, 0, 130, 1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Dalam Proses',
                'data' => $inProgressData,
                'backgroundColor' => 'rgba(192, 192, 192, 0.2)',
                'borderColor' => 'rgba(192, 192, 192, 1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Tepat Waktu',
                'data' => $onTimeData,
                'backgroundColor' => 'rgba(0, 255, 0, 0.2)',
                'borderColor' => 'rgba(0, 255, 0, 1)',
                'borderWidth' => 1
            ],
            
        ]
    ];
    if (Auth::user()->role != 3) {
        $chartData['datasets'][] = [
            'label' => 'Tidak Tepat Waktu',
            'data' => $lateData,
            'backgroundColor' => 'rgba(255, 0, 0, 0.2)',
            'borderColor' => 'rgba(255, 0, 0, 1)',
            'borderWidth' => 1
        ];
    }

    return view('dashboard.index', compact('totalActual', 'totalPlan', 'totalOnTime', 'totalLate', 'years', 'chartData', 'selectedYear'));
}


    public function user()
    {
        $users = User::all();
        return view('dashboard.pages.user.index', compact('users'));
    }

    public function userCreate()
    {
        return view('dashboard.pages.user.create');
    }

    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        toastr()->success('User berhasil ditambahkan!');

        return redirect()->route('dashboard.user');
    }

    public function userEdit(User $user)
    {
        return view('dashboard.pages.user.create', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|integer',
        ]);

        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
        ]);
        // dd($request);

        toastr()->success('User berhasil diperbarui!');

        return redirect()->route('dashboard.user');
    }

    public function userDestroy(User $user)
    {
        $user->delete();
        toastr()->success('User berhasil dihapus!');
        return redirect()->route('dashboard.user');
    }
}
