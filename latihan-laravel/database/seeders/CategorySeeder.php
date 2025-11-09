<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pakai user utama
        $user = User::where('email', 'admin@example.com')->first()
            ?? User::first(); // fallback

        if (! $user) {
            return;
        }

        $defaultCategories = [
            ['name' => 'Makanan',     'color' => '#f97316'],
            ['name' => 'Transportasi','color' => '#0ea5e9'],
            ['name' => 'Belanja',     'color' => '#a855f7'],
            ['name' => 'Tagihan',     'color' => '#ef4444'],
            ['name' => 'Gaji',        'color' => '#22c55e'],
        ];

        foreach ($defaultCategories as $cat) {
            Category::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'name'    => $cat['name'],
                ],
                [
                    'color'   => $cat['color'],
                ]
            );
        }

        // tambahan kategori random
        Category::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
