<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChartService
{
    /**
     * Ambil data pemasukan & pengeluaran per bulan untuk user.
     *
     * @param  int  $userId
     * @return array
     */
    public function monthlyIncomeExpense(int $userId): array
    {
        // ambil data dari DB
        $rows = Transaction::ownedBy($userId)
            ->select(
                DB::raw("DATE_TRUNC('month', occurred_at) AS month"),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense"),
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // format ulang buat charting
        $categories = [];
        $incomeSeries = [];
        $expenseSeries = [];

        /** @var \App\Models\Transaction $row */
        foreach ($rows as $row) {
            // month dari postgres -> Carbon, tapi kita bisa format manual yyyy-mm
            $monthLabel = date('Y-m', strtotime($row->month));
            $categories[] = $monthLabel;
            $incomeSeries[] = (float) $row->total_income;
            $expenseSeries[] = (float) $row->total_expense;
        }

        return [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Income',
                    'data' => $incomeSeries,
                ],
                [
                    'name' => 'Expense',
                    'data' => $expenseSeries,
                ],
            ],
        ];
    }

    /**
     * Ambil ringkasan total income & expense (buat card kecil di dashboard).
     */
    public function summary(int $userId): array
    {
        $income = Transaction::ownedBy($userId)->where('type', 'income')->sum('amount');
        $expense = Transaction::ownedBy($userId)->where('type', 'expense')->sum('amount');

        return [
            'income'  => (float) $income,
            'expense' => (float) $expense,
            'balance' => (float) $income - (float) $expense,
        ];
    }
}
