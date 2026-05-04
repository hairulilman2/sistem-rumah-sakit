<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'complaint' => 'required|string|min:10|max:500',
        ]);

        $patient = auth()->user()->patient;

        if (!$patient) {
            return back()->with('error', 'Anda harus melengkapi data pasien terlebih dahulu.');
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'schedule_date' => $validated['schedule_date'],
            'start_time' => $validated['start_time'],
            'complaint' => $validated['complaint'],
            'status' => 'pending',
        ]);

        // Create notifications
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Appointment Berhasil Dibuat',
            'message' => 'Appointment Anda telah berhasil dibuat dan menunggu konfirmasi.',
            'type' => 'appointment',
        ]);

        return redirect()->route('pasien.index')->with('success', 'Appointment berhasil dibuat. Silakan tunggu konfirmasi.');
    }
}
