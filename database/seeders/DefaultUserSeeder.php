<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::where('type', 'superadmin')->first();
        $company = User::where('type', 'company')->first();
        if (empty($company)) {
            $company = new User();
            $company->name = 'Company';
            $company->email = 'company@example.com';
            $company->password = Hash::make('12345678');
            $company->type = 'company';
            $company->created_by = $superAdmin->id;
            $company->save();

            $companyRole = Role::where('name', 'company')->first();
            $company->roles()->attach($companyRole);

            $data = $company->makeRoles();
        } else {
            $company->makeRoles();
        }


        $manager = User::where('type', 'manager')->first();
        if (empty($manager)) {
            $manager = new User();
            $manager->name = 'Manager';
            $manager->email = 'manager@example.com';
            $manager->password = Hash::make('12345678');
            $manager->type = 'manager';
            $manager->created_by = $company->id;
            $manager->save();

            $managerRole = Role::where('name', 'manager')->first();
            if ($managerRole) {
                $manager->roles()->attach($managerRole);
            }
        }

        $employee = User::where('type', 'employee')->first();
        if (empty($employee)) {
            $employee = new User();
            $employee->name = 'Employee';
            $employee->email = 'employee@example.com';
            $employee->password = Hash::make('12345678');
            $employee->type = 'employee';
            $employee->created_by =  $company->id;
            $employee->save();

            $employeeRole = Role::where('name', 'employee')->first();
            if ($employeeRole) {
                $employee->roles()->attach($employeeRole);
            }
        }
    }
}
