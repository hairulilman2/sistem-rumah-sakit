<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryPublicController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('public.galeri.index', compact('galleries'));
    }
}
