@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="ck-container" style="max-width: 720px;">
        <div class="ck-card">
            <div class="ck-card-header">
                <div>
                    <h1 class="ck-card-title">Edit Transaksi</h1>
                    <p class="ck-card-subtitle">Perbarui data transaksi ini.</p>
                </div>
            </div>

            <form action="{{ route('transactions.update', $transaction) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-3">
                @csrf
                @method('PUT')

                <div class="ck-form-group">
                    <label for="title" class="ck-label">Judul / Nama transaksi</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $transaction->title) }}"
                           class="ck-input" required>
                </div>

                <div class="ck-form-group">
                    <label for="type" class="ck-label">Tipe</label>
                    <select name="type" id="type" class="ck-select">
                        <option value="income" @selected(old('type', $transaction->type) === 'income')>Pemasukan</option>
                        <option value="expense" @selected(old('type', $transaction->type) === 'expense')>Pengeluaran</option>
                    </select>
                </div>

                <div class="ck-form-group">
                    <label for="category_id" class="ck-label">Kategori</label>
                    <select name="category_id" id="category_id" class="ck-select">
                        <option value="">-- Tanpa kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $transaction->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ck-form-group">
                    <label for="occurred_at" class="ck-label">Tanggal</label>
                    <input type="date" name="occurred_at" id="occurred_at"
                           value="{{ old('occurred_at', \Carbon\Carbon::parse($transaction->occurred_at)->toDateString()) }}"
                           class="ck-input">
                </div>

                <div class="ck-form-group">
                    <label for="amount" class="ck-label">Nominal</label>
                    <input type="number" name="amount" id="amount"
                           value="{{ old('amount', $transaction->amount) }}"
                           class="ck-input" min="0" required>
                </div>

                <div class="ck-form-group">
                    <label for="note" class="ck-label">Catatan (opsional)</label>
                    <textarea name="note" id="note" rows="3" class="ck-input" style="resize:vertical;">{{ old('note', $transaction->note) }}</textarea>
                </div>

                <div class="ck-form-group">
                    <label for="cover" class="ck-label">Upload bukti (opsional)</label>
                    <input type="file" name="cover" id="cover" accept="image/*" class="ck-input" style="padding:.35rem;">
                    @if ($transaction->cover_path)
                        <p class="text-muted mt-2" style="font-size:.7rem;">Bukti saat ini:</p>
                        <img src="{{ asset('storage/' . $transaction->cover_path) }}" alt="cover"
                             style="max-width:200px;border-radius:.5rem;margin-top:.35rem;">
                    @endif
                </div>

                <div style="display:flex;gap:.5rem;justify-content:flex-end;">
                    <a href="{{ route('transactions.index') }}" class="ck-btn ck-btn-ghost">Batal</a>
                    <button class="ck-btn ck-btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
