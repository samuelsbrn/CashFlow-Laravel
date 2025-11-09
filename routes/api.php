<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;

// contoh route api bawaan laravel
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// contoh endpoint untuk ambil transaksi user yang login
Route::middleware('auth:sanctum')->get('/transactions', function (Request $request) {
    return TransactionResource::collection(
        Transaction::where('user_id', $request->user()->id)
            ->latest('occurred_at')
            ->limit(50)
            ->get()
    );
});
