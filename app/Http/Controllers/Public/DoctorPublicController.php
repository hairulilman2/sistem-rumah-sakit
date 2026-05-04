<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::active()->with('user', 'schedules');

        if ($request->has('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        if ($request->has('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $doctors = $query->paginate(12);
        $specializations = Doctor::active()->distinct('specialization')->pluck('specialization');

        return view('public.dokter.index', compact('doctors', 'specializations'));
    }

    public function show($id)
    {
        $doctor = Doctor::active()->with('user', 'schedules')->findOrFail($id);
        return view('public.dokter.show', compact('doctor'));
    }
}
