<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user utama
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Catatan',
                'password' => Hash::make('password'), // ganti kalau mau
            ]
        );

        // kalau mau tambah user random:
        User::factory()->count(2)->create();
    }
}
