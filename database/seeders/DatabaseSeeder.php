<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@vaccitrack.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->email_verified_at) {
            $admin->update(['email_verified_at' => now()]);
        }

        $admin->assignRole('admin');

        $this->call(VaccinationSystemSeeder::class);
    }
}
