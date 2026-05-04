<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-users', 'manage-roles', 'manage-settings', 'view-audit-logs',
            'manage-doctors', 'manage-schedules', 'manage-departments', 'manage-services',
            'manage-facilities', 'manage-news', 'manage-gallery', 'manage-appointments',
            'view-appointments', 'confirm-appointments', 'manage-contacts',
            'view-reports', 'manage-profile', 'book-appointment', 'view-own-appointments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions (super-admin removed)
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $dokter = Role::create(['name' => 'dokter']);
        $dokter->givePermissionTo([
            'manage-profile', 'manage-schedules', 'view-appointments', 'manage-news',
        ]);

        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo([
            'view-appointments', 'confirm-appointments', 'manage-contacts',
        ]);

        $pasien = Role::create(['name' => 'pasien']);
        $pasien->givePermissionTo([
            'manage-profile', 'book-appointment', 'view-own-appointments',
        ]);
    }
}
