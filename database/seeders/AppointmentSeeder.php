<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $statuses = ['pending', 'confirmed', 'cancelled', 'done'];

        if ($patients->count() == 0 || $doctors->count() == 0) {
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'schedule_date' => now()->addDays(rand(-10, 10)),
                'start_time' => '08:00',
                'complaint' => 'Keluhan kesehatan ' . ($i + 1),
                'status' => $statuses[rand(0, 3)],
                'notes' => rand(0, 1) ? 'Catatan appointment ' . ($i + 1) : null,
            ]);
        }
    }
}
