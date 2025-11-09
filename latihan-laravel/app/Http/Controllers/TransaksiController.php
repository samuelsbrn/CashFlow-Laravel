<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction; // sesuaikan dengan nama model kamu

class TransaksiController extends Controller
{
    /**
     * Tampilkan form tambah transaksi.
     */
    public function create()
    {
        // nanti view-nya bikin di resources/views/transaksi/create.blade.php
        return view('transaksi.create');
    }

    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        // validasi sederhana, silakan sesuaikan field-nya
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'occurred_at' => 'nullable|date',
        ]);

        // simpan ke database
        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'occurred_at' => $validated['occurred_at'] ?? now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
