<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
{
    $agendas = Agendas::all();

    // Count the number of records with a non-null end_dt_a
    $totalActual = Agendas::whereNotNull('end_dt_a')->count();
    $totalPlan = Agendas::whereNull('end_dt_a')->count();

    // Extract unique years from agendas
    $years = Agendas::selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

    // Group agendas by year and month
    $agendasByYear = $agendas->groupBy(function($item) {
        return $item->created_at->format('Y');
    });

    $chartData = [];
    foreach ($agendasByYear as $year => $yearAgendas) {
        $monthlyData = $yearAgendas->groupBy(function($item) {
            return $item->created_at->format('n'); // Group by month number
        });

        $completedData = [];
        $inProgressData = [];
        for ($i = 1; $i <= 12; $i++) {
            $completedData[] = isset($monthlyData[$i]) ? $monthlyData[$i]->whereNotNull('end_dt_a')->count() : 0;
            $inProgressData[] = isset($monthlyData[$i]) ? $monthlyData[$i]->whereNull('end_dt_a')->count() : 0;
        }

        $chartData[$year] = [
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
                ]
            ]
        ];
    }

    return view('dashboard.index', compact('agendas', 'totalActual', 'totalPlan', 'years', 'chartData'));
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
            'password' => 'required|string|min:8|confirmed',
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
            'password' => 'nullable|string|min:8|confirmed',
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
