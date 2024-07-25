<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        $agendas = Agendas::all();

        return view('dashboard.pages.resources.pages.timeline', compact('agendas'));
    }
}
