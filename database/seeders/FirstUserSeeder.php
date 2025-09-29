<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FirstUserSeeder extends Seeder
{
    public function run()
    {
         
        $role = Role::firstOrCreate([
            'name' => 'Super-Admin',
            'slug' => 'super-admin',
        ]);

        $user = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $user->roles()->associate($role);
        $user->save();

        $permissions = Permission::all();
        $role->permissions()->sync($permissions->pluck('id')->toArray()); //optional
    }
}