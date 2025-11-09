<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CarbonImmutable;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ringkasan
        $income  = (int) Transaction::ownedBy($userId)->where('type', 'income')->sum('amount');
        $expense = (int) Transaction::ownedBy($userId)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        // Agregasi per bulan (Postgres) — gunakan ekspresi langsung untuk GROUP BY/ORDER BY
        $rows = Transaction::ownedBy($userId)
            ->selectRaw("
                DATE_TRUNC('month', occurred_at) AS month_key,
                SUM(CASE WHEN type = 'income'  THEN amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense
            ")
            ->groupBy(DB::raw("DATE_TRUNC('month', occurred_at)"))
            ->orderBy(DB::raw("DATE_TRUNC('month', occurred_at)"))
            ->get();

        // Siapkan data untuk chart dengan label Indonesia "Okt 2025", dst.
        $labels      = [];
        $incomeData  = [];
        $expenseData = [];

        foreach ($rows as $row) {
            $labels[]      = CarbonImmutable::parse($row->month_key)->locale('id')->translatedFormat('MMM Y');
            $incomeData[]  = (int) $row->total_income;
            $expenseData[] = (int) $row->total_expense;
        }

        // NOTE: sesuaikan nama view dengan file-mu.
        // Jika file-nya resources/views/dashboard.blade.php -> gunakan 'dashboard'
        // Jika folder 'dashboard/index.blade.php' -> gunakan 'dashboard.index'
        return view('dashboard', [
            'income'      => $income,
            'expense'     => $expense,
            'balance'     => $balance,
            'labels'      => $labels,
            'incomeData'  => $incomeData,
            'expenseData' => $expenseData,
        ]);
    }
}
