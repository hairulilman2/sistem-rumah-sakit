<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\News;
use App\Models\Service;
use App\Models\Appointment;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'doctors' => Doctor::active()->count(),
            'services' => Service::active()->count(),
            'appointments' => Appointment::whereDate('schedule_date', today())->count(),
            'patients' => Appointment::distinct('patient_id')->count(),
        ];

        $featuredDoctors = Doctor::active()->with('user')->take(6)->get();
        $latestNews = News::published()->with('category', 'author')->latest('published_at')->take(3)->get();
        $services = Service::active()->with('department')->take(6)->get();

        return view('public.home.index', compact('stats', 'featuredDoctors', 'latestNews', 'services'));
    }
}
