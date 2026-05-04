<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Facility;

class FacilityPublicController extends Controller
{
    public function index()
    {
        $facilities = Facility::active()->get()->groupBy('category');
        return view('public.fasilitas.index', compact('facilities'));
    }
}
