<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'role_name' => 'admin',
        ]);

        Role::create([
            'role_name' => 'pelapor',
        ]);

        Role::create([
            'role_name' => 'surveyor',
        ]);

        Role::create([
            'role_name' => 'kabid',
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
        ]);

        $this->call([
            AspekSeeder::class,
        ]);
    }
}
