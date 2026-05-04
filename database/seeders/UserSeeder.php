<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
// Super Admin removed

        // Admin
        $admin = User::create([
            'name' => 'Admin RS',
            'email' => 'admin@rumahsakit.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'is_active' => true,
        ]);
$admin->assignRole('admin'); // Admin now has full access

        // Dokter
        $doctors = [
            ['name' => 'Dr. Ahmad Fauzi, Sp.PD', 'email' => 'ahmad.fauzi@rumahsakit.com', 'phone' => '081234567892'],
            ['name' => 'Dr. Siti Nurhaliza, Sp.A', 'email' => 'siti.nurhaliza@rumahsakit.com', 'phone' => '081234567893'],
            ['name' => 'Dr. Budi Santoso, Sp.OG', 'email' => 'budi.santoso@rumahsakit.com', 'phone' => '081234567894'],
            ['name' => 'Dr. Rina Wijaya, Sp.JP', 'email' => 'rina.wijaya@rumahsakit.com', 'phone' => '081234567895'],
            ['name' => 'Dr. Hendra Gunawan, Sp.B', 'email' => 'hendra.gunawan@rumahsakit.com', 'phone' => '081234567896'],
        ];

        foreach ($doctors as $doctor) {
            $user = User::create([
                'name' => $doctor['name'],
                'email' => $doctor['email'],
                'password' => Hash::make('password'),
                'phone' => $doctor['phone'],
                'is_active' => true,
            ]);
            $user->assignRole('dokter');
        }

        // Staff
        $staffs = [
            ['name' => 'Staff 1', 'email' => 'staff1@rumahsakit.com', 'phone' => '081234567897'],
            ['name' => 'Staff 2', 'email' => 'staff2@rumahsakit.com', 'phone' => '081234567898'],
        ];

        foreach ($staffs as $staff) {
            $user = User::create([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => Hash::make('password'),
                'phone' => $staff['phone'],
                'is_active' => true,
            ]);
            $user->assignRole('staff');
        }

        // Pasien
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Pasien $i",
                'email' => "pasien$i@example.com",
                'password' => Hash::make('password'),
                'phone' => '0812345678' . str_pad($i + 98, 2, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
            $user->assignRole('pasien');
            
            // Create patient record
            \App\Models\Patient::create([
                'user_id' => $user->id,
                'nik' => '320101010101' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'birth_date' => now()->subYears(rand(20, 60)),
                'gender' => $i % 2 == 0 ? 'L' : 'P',
                'blood_type' => ['A', 'B', 'AB', 'O'][rand(0, 3)],
                'address' => 'Jl. Contoh No. ' . $i,
                'emergency_contact' => '081234567' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
