<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $user = User::create([
            "nik" => "1111111",
            "name" => "Administrator",
            "username" => "Admin",
            "email" => "admin@test.test",
            "photo" => null,
            "telp" => "090122",
            "password" => Hash::make('12345678'),
        ]);

        $user->assignRole($role);
    }
}
