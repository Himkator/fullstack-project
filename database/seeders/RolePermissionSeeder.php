<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder {
    public function run(): void {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view courses']);
        Permission::create(['name' => 'enroll courses']);
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage own courses']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage own users']);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo('view courses', 'manage own courses', 'manage own users');

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo(['view courses', 'enroll courses']);

        $instructor = Role::create(['name' => 'instructor']);
        $instructor->givePermissionTo(['view courses', 'manage own users']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $adminUser = User::create([
            'login'    => 'admin',
            'email'    => 'admin@f1academy.com',
            'password' => 'admin123',
        ]);
        $adminUser->assignRole('admin');
    }
}