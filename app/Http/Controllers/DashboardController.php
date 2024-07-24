<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function user()
    {
        $users = User::all();
        return view('dashboard.pages.user.index', compact('users'));
    }
}
