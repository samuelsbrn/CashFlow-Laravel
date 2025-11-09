<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Services\ChartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ChartServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_monthly_data_for_user()
    {
        $user = User::factory()->create();

        // transaksi bulan ini
        Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 1000000,
            'occurred_at' => Carbon::now()->startOfMonth(),
        ]);

        // transaksi bulan lalu
        Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'expense',
            'amount' => 200000,
            'occurred_at' => Carbon::now()->subMonth()->startOfMonth(),
        ]);

        $service = new ChartService();
        $data = $service->monthlyIncomeExpense($user->id);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('categories', $data);
        $this->assertArrayHasKey('series', $data);
        $this->assertNotEmpty($data['categories']);
        $this->assertNotEmpty($data['series']);
    }
}
