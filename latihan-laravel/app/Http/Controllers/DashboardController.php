<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // total pemasukan
        $income = Transaction::ownedBy($userId)
            ->where('type', 'income')
            ->sum('amount');

        // total pengeluaran
        $expense = Transaction::ownedBy($userId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $income - $expense;

        // ambil data per bulan untuk grafik
        $rows = Transaction::ownedBy($userId)
            ->select(
                DB::raw("DATE_TRUNC('month', occurred_at) AS month"),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ubah ke array simple buat di-JSON-kan ke JS
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        foreach ($rows as $row) {
            // tampilkan bulan dalam format singkat
            $labels[] = date('M Y', strtotime($row->month));
            $incomeData[] = (float) $row->total_income;
            $expenseData[] = (float) $row->total_expense;
        }

        return view('dashboard.index', [
            'income'      => $income,
            'expense'     => $expense,
            'balance'     => $balance,
            'labels'      => $labels,
            'incomeData'  => $incomeData,
            'expenseData' => $expenseData,
        ]);
    }
}
