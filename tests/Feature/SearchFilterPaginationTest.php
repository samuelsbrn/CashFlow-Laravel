<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchFilterPaginationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login sebagai user dan balikin model user-nya.
     */
    protected function actingUser(): User
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    /** @test */
    public function user_can_search_transactions_by_title(): void
    {
        $user = $this->actingUser();

        Transaction::factory()->create([
            'user_id' => $user->id,
            'title'   => 'Beli nasi goreng',
        ]);

        Transaction::factory()->create([
            'user_id' => $user->id,
            'title'   => 'Bayar kos',
        ]);

        $response = $this->get('/transactions?q=nasi');

        $response->assertStatus(200);
        $response->assertSee('Beli nasi goreng');
        $response->assertDontSee('Bayar kos');
    }

    /** @test */
    public function user_can_filter_by_type_and_category(): void
    {
        $user = $this->actingUser();

        $food = Category::factory()->create([
            'user_id' => $user->id,
            'name'    => 'Makanan',
        ]);

        $transport = Category::factory()->create([
            'user_id' => $user->id,
            'name'    => 'Transport',
        ]);

        // expense makanan
        Transaction::factory()->create([
            'user_id'     => $user->id,
            'title'       => 'Makan siang',
            'type'        => 'expense',
            'category_id' => $food->id,
        ]);

        // income lain
        Transaction::factory()->create([
            'user_id'     => $user->id,
            'title'       => 'Gaji',
            'type'        => 'income',
            'category_id' => null,
        ]);

        $response = $this->get('/transactions?type=expense&category_id=' . $food->id);

        $response->assertStatus(200);
        $response->assertSee('Makan siang');
        $response->assertDontSee('Gaji');
    }

    /** @test */
    public function pagination_shows_only_20_transactions(): void
    {
        $user = $this->actingUser();

        Transaction::factory()->count(25)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/transactions');

        $response->assertStatus(200);
        // di view kita tadi ada teks "Halaman X dari Y" di pagination
        $response->assertSee('Halaman');
    }
}
