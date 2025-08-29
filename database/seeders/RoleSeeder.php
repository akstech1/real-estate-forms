<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);
        $maintenanceAndCleaningCompany = Role::firstOrCreate(['name' => 'Maintenance and cleaning company', 'guard_name' => 'web']);
        $realEstateCompany = Role::firstOrCreate(['name' => 'Real estate company', 'guard_name' => 'web']);
        $consultative = Role::firstOrCreate(['name' => 'Consultative', 'guard_name' => 'web']);



        // Assign Super Admin role to existing admin user
        $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('Super Admin');
        }
    }
}
