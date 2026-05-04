<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['email' => 'ahmad.fauzi@rumahsakit.com', 'nik' => '3201010101010001', 'specialization' => 'Penyakit Dalam', 'education' => 'S2 Kedokteran Universitas Indonesia', 'experience' => 10],
            ['email' => 'siti.nurhaliza@rumahsakit.com', 'nik' => '3201010101010002', 'specialization' => 'Anak', 'education' => 'S2 Kedokteran Universitas Gadjah Mada', 'experience' => 8],
            ['email' => 'budi.santoso@rumahsakit.com', 'nik' => '3201010101010003', 'specialization' => 'Kandungan', 'education' => 'S2 Kedokteran Universitas Airlangga', 'experience' => 12],
            ['email' => 'rina.wijaya@rumahsakit.com', 'nik' => '3201010101010004', 'specialization' => 'Jantung', 'education' => 'S2 Kedokteran Universitas Padjadjaran', 'experience' => 15],
            ['email' => 'hendra.gunawan@rumahsakit.com', 'nik' => '3201010101010005', 'specialization' => 'Bedah', 'education' => 'S2 Kedokteran Universitas Diponegoro', 'experience' => 9],
        ];

        foreach ($doctors as $doctorData) {
            $user = User::where('email', $doctorData['email'])->first();
            
            if ($user) {
                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'nik' => $doctorData['nik'],
                    'specialization' => $doctorData['specialization'],
                    'education' => $doctorData['education'],
                    'experience' => $doctorData['experience'],
                    'str_number' => 'STR-' . rand(100000, 999999),
                    'bio' => 'Dokter spesialis ' . $doctorData['specialization'] . ' dengan pengalaman ' . $doctorData['experience'] . ' tahun.',
                    'is_active' => true,
                ]);

                // Create schedules
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                foreach ($days as $day) {
                    DoctorSchedule::create([
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $day,
                        'start_time' => '08:00',
                        'end_time' => '12:00',
                        'max_quota' => 20,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
