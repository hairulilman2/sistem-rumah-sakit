<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePatientExists
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('pasien')) {
            if (!auth()->user()->patient) {
                \App\Models\Patient::create([
                    'user_id' => auth()->id(),
                    'nik' => '3201' . str_pad(auth()->id(), 12, '0', STR_PAD_LEFT),
                    'birth_date' => now()->subYears(25),
                    'gender' => 'L',
                    'blood_type' => 'O',
                    'address' => 'Alamat belum diisi',
                    'emergency_contact' => '08123456789',
                ]);
            }
        }

        return $next($request);
    }
}
