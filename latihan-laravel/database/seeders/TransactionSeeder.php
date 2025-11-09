<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first()
            ?? User::first();

        if (! $user) {
            return;
        }

        $categories = Category::where('user_id', $user->id)->pluck('id')->toArray();

        // kalau belum ada kategori sama sekali, ya sudah bikin transaksi tanpa kategori
        Transaction::factory()->count(20)->create([
            'user_id' => $user->id,
        ])->each(function (Transaction $trx) use ($categories) {
            if (!empty($categories)) {
                $trx->category_id = collect($categories)->random();
                $trx->save();
            }
        });

        // contoh transaksi manual (biar ada yang pasti kelihatan)
        Transaction::create([
            'user_id'     => $user->id,
            'category_id' => $categories[0] ?? null,
            'type'        => 'income',
            'title'       => 'Gaji Bulanan',
            'note'        => 'Gaji tetap bulan ini',
            'amount'      => 3500000,
            'occurred_at' => now()->subDays(3),
            'cover_path'  => null,
        ]);

        Transaction::create([
            'user_id'     => $user->id,
            'category_id' => $categories[1] ?? null,
            'type'        => 'expense',
            'title'       => 'Makan di kantin',
            'note'        => 'Nasi goreng + es teh',
            'amount'      => 25000,
            'occurred_at' => now(),
            'cover_path'  => null,
        ]);
    }
}
