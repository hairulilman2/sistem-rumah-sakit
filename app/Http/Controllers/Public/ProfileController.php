<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('public.profil.index');
    }
}
