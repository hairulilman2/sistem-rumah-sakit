<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Department;

class ServicePublicController extends Controller
{
    public function index()
    {
        $departments = Department::active()->with('services')->get();
        return view('public.layanan.index', compact('departments'));
    }
}
