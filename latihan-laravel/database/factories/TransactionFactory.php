<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['income', 'expense']);

        return [
            'user_id'     => User::factory(),
            'category_id' => null, // bisa diisi di seeder
            'type'        => $type,
            'title'       => $type === 'income'
                                ? $this->faker->randomElement(['Gaji', 'Bonus', 'Hadiah'])
                                : $this->faker->sentence(3),
            'note'        => $this->faker->optional()->sentence(),
            'amount'      => $type === 'income'
                                ? $this->faker->numberBetween(100000, 5000000)
                                : $this->faker->numberBetween(5000, 250000),
            'occurred_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'cover_path'  => null,
        ];
    }
}
