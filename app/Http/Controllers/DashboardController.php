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

        // $totalActual = 

        return view('dashboard.index', compact('agendas'));
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
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
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
