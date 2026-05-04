<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'IGD (Instalasi Gawat Darurat)', 'icon' => 'emergency', 'description' => 'Pelayanan gawat darurat 24 jam'],
            ['name' => 'Rawat Inap', 'icon' => 'bed', 'description' => 'Pelayanan rawat inap dengan berbagai kelas'],
            ['name' => 'Poli Umum', 'icon' => 'stethoscope', 'description' => 'Pelayanan kesehatan umum'],
            ['name' => 'Poli Gigi', 'icon' => 'tooth', 'description' => 'Pelayanan kesehatan gigi dan mulut'],
            ['name' => 'Laboratorium', 'icon' => 'flask', 'description' => 'Pemeriksaan laboratorium lengkap'],
            ['name' => 'Radiologi', 'icon' => 'x-ray', 'description' => 'Pemeriksaan radiologi dan imaging'],
        ];

        foreach ($departments as $dept) {
            Department::create([
                'name' => $dept['name'],
                'slug' => Str::slug($dept['name']),
                'description' => $dept['description'],
                'icon' => $dept['icon'],
                'is_active' => true,
            ]);
        }
    }
}
