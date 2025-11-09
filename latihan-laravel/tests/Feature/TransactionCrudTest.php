<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper untuk login sebagai user baru.
     *
     * @return \App\Models\User
     */
    protected function actingUser(): User
    {
        /** @var User $user */
        $user = User::factory()->create(); // Intelephense: ini model ya
        $this->actingAs($user);

        return $user;
    }

    /** @test */
    public function user_can_view_transaction_index()
    {
        $user = $this->actingUser();

        Transaction::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/transactions');

        $response->assertStatus(200);
        $response->assertSee('Daftar Transaksi');
    }

    /** @test */
    public function user_can_create_transaction()
    {
        $user = $this->actingUser();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->post('/transactions', [
            'title'       => 'Beli makan',
            'type'        => 'expense',
            'category_id' => $category->id,
            'amount'      => 20000,
            'occurred_at' => now()->toDateString(),
            'note'        => 'makan siang',
        ]);

        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', [
            'title'    => 'Beli makan',
            'user_id'  => $user->id,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function user_can_update_transaction()
    {
        $user = $this->actingUser();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'title'   => 'judul lama',
        ]);

        $response = $this->put("/transactions/{$transaction->id}", [
            'title'       => 'judul baru',
            'type'        => $transaction->type,
            'category_id' => $transaction->category_id,
            'amount'      => $transaction->amount,
            'occurred_at' => $transaction->occurred_at->toDateString(),
            'note'        => $transaction->note,
        ]);

        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', [
            'id'    => $transaction->id,
            'title' => 'judul baru',
        ]);
    }

    /** @test */
    public function user_can_delete_their_transaction()
    {
        $user = $this->actingUser();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete("/transactions/{$transaction->id}");
        $response->assertRedirect('/transactions');

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id,
        ]);
    }

    /** @test */
    public function user_cannot_delete_others_transaction()
    {
        $user = $this->actingUser();
        $otherUser = User::factory()->create();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->delete("/transactions/{$transaction->id}");
        $response->assertStatus(403);
    }
}
