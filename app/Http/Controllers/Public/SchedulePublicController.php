<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

class SchedulePublicController extends Controller
{
    public function index()
    {
        $doctors = Doctor::active()->with('user', 'schedules')->get();
        return view('public.jadwal.index', compact('doctors'));
    }
}
