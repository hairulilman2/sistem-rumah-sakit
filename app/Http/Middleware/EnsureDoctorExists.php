<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDoctorExists
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('dokter')) {
            if (!auth()->user()->doctor) {
                return redirect()->route('home')->with('error', 'Data dokter belum lengkap. Hubungi admin.');
            }
        }

        return $next($request);
    }
}
