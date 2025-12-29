<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $admin = User::where('email', 'admin@gmail.com')->first();

            if (!$admin) {
                $user = User::create([
                    "first_name" => "admin",
                    "last_name" => "Singh",
                    "email" => "admin@gmail.com",
                    "password" => Hash::make("Shine@123"),
                    "encrypt_password" => jsencode_userdata('Shine@123'),
                    "email_verified_at" => now(),
                ]);
            }

            $permissions = Permission::all();

            // model_has_permissions entry
            foreach ($permissions as $permission) {
                $user->givePermissionTo($permission);
            }

            // model_has_roles
            $role = Role::where('name', 'Administrator')->first();
            if ($role) {
                $user->assignRole($role);
            }
            //model_has_permissions , role_has_permissions
            $role->syncPermissions(Permission::all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
