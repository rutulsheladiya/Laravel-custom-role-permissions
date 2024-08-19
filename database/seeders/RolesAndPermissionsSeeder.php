<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create super admin , create it role , assign super admin role to user , assign super admin permission
        $superAdmin = User::where('type', 'superadmin')->first();

        if (empty($superAdmin)) {
            $superAdmin = new User();
            $superAdmin->name = 'Super Admin';
            $superAdmin->email = 'superadmin@example.com';
            $superAdmin->password = Hash::make('12345678');
            $superAdmin->type = 'superadmin';
            $superAdmin->created_by = null;
            $superAdmin->save();

            $superAdminRole = Role::where('name', 'super admin')->first();
            if (empty($superAdminRole)) {
                $superAdminRole  = Role::create(
                    [
                        'name' => 'super admin',
                        'created_by' => 0,
                    ]
                );
            }
            $getSuperAdminRole = Role::where('name', 'super admin')->first();

            // here roles() method will check superadmin user have a superadmin role or not.
            $superAdmin->roles()->attach($getSuperAdminRole);
        }

        $superAdminDefaultPermission = [
            'dashboard' => ['view dashboard'],
            'company' => ['manage company', 'create company', 'edit company', 'delete company'],
            'plan' => ['manage plan', 'create plan', 'edit plan', 'delete plan'],
            'profile' => ['manage profile'],
        ];

        $companyPermission = [
            'dashboard' => ['view dashboard'],
            'profile' => ['manage profile'],
            'plan' => ['manage plan'],
            'role' => ['manage role', 'create role', 'edit role', 'delete role'],
            'user' => ['manage user', 'create user', 'edit user', 'delete user'],
            'project' => ['manage project', 'create project', 'edit project', 'delete project'],
        ];

        // Merge both arrays
        $mergedPermissions = array_merge_recursive($superAdminDefaultPermission, $companyPermission);

        // Prepare the final array for insertion into the permission table
        $finalPermissions = [];
        foreach ($mergedPermissions as $scope => $permissions) {
            // Remove duplicates
            $uniquePermissions = array_unique($permissions);
            $finalPermissions[$scope] = $uniquePermissions;
        }

        // Insert permissions into the permissions table if not already present
        $superAdmin = User::where('type', 'superadmin')->first();
        foreach ($finalPermissions as $scope => $scopeOfPermission) {
            foreach ($scopeOfPermission as $permission) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permission],
                    [
                        'scope' => $scope,
                        'created_by' => $superAdmin->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }

        // Assign permissions to super admin role
        $superAdminRole = Role::where('name', 'super admin')->first();
        foreach ($superAdminDefaultPermission as $scope => $permissionArr) {
            foreach ($permissionArr as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission) {
                    if (!$superAdminRole->hasPermission($permissionName)) {
                        $superAdminRole->givePermission($permission);
                    }
                }
            }
        }


        $companyRole = Role::where('name', 'company')->first();
        if (empty($companyRole)) {
            $companyRole = Role::create([
                'name' => 'company',
                'created_by' => $superAdmin->id,
            ]);
        }

        foreach ($companyPermission as $scope => $permissionArray) {
            foreach ($permissionArray as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission) {
                    if (!$companyRole->hasPermission($permissionName)) {
                        $companyRole->givePermission($permission);
                    }
                }
            }
        }
    }
}
