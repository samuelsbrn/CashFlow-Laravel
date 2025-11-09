{{-- resources/views/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
  <div class="max-w-3xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
      <div>
        <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase mb-1">Transaksi</p>
        <h1 class="text-2xl font-semibold text-slate-900">Detail Transaksi</h1>
        <p class="text-slate-500 text-sm">Info lengkap transaksi yang kamu pilih.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('transactions.edit', $transaction) }}"
           class="inline-flex items-center h-10 px-4 rounded-lg text-sm bg-slate-100 text-slate-700 hover:bg-slate-200">
          Edit
        </a>
        <a href="{{ route('transactions.index') }}"
           class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700">
          Kembali
        </a>
      </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      {{-- Title Row --}}
      <div class="px-6 pt-6 pb-2">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div>
            <h2 class="text-xl font-semibold text-slate-900">
              {{ $transaction->title ?? ($transaction->description ?? 'Transaksi') }}
            </h2>
            @php
              $isIncome = $transaction->type === 'income';
              $catName  = $transaction->category->name ?? 'Tanpa Kategori';
              $catColor = $transaction->category->color ?? '#a78bfa';
              $dateStr  = \Carbon\Carbon::parse($transaction->occurred_at)->translatedFormat('d M Y');
              $amount   = number_format($transaction->amount, 0, ',', '.');
            @endphp
            <div class="mt-1 flex flex-wrap items-center gap-2 text-sm">
              {{-- Tipe Badge --}}
              @if($isIncome)
                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 text-xs">
                  <span class="text-emerald-500">●</span> Pemasukan
                </span>
              @else
                <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 text-rose-700 border border-rose-100 px-2 py-0.5 text-xs">
                  <span class="text-rose-500">●</span> Pengeluaran
                </span>
              @endif>

              {{-- Kategori chip --}}
              <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 text-slate-700 border border-slate-200 px-2 py-0.5 text-xs">
                <span class="w-3 h-3 rounded-full border border-slate-200" style="background: {{ $catColor }}"></span>
                {{ $catName }}
              </span>

              {{-- Tanggal --}}
              <span class="text-slate-500 text-xs">• {{ $dateStr }}</span>
            </div>
          </div>

          {{-- Amount --}}
          <div class="text-right">
            @if($isIncome)
              <div class="text-2xl font-bold text-emerald-600">+ Rp {{ $amount }}</div>
            @else
              <div class="text-2xl font-bold text-rose-600">- Rp {{ $amount }}</div>
            @endif
            <div class="text-xs text-slate-400">Nominal</div>
          </div>
        </div>
      </div>

      {{-- Divider --}}
      <div class="h-px bg-slate-100 my-4"></div>

      {{-- Meta grid --}}
      <div class="px-6 pb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
            <p class="text-xs text-slate-500 mb-1">Judul</p>
            <p class="font-medium text-slate-900">
              {{ $transaction->title ?? '-' }}
            </p>
          </div>

          <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
            <p class="text-xs text-slate-500 mb-1">Tanggal</p>
            <p class="font-medium text-slate-900">{{ $dateStr }}</p>
          </div>

          <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 sm:col-span-2">
            <p class="text-xs text-slate-500 mb-1">Catatan</p>
            <p class="text-slate-800">
              {{ $transaction->note ?? $transaction->description ?? '—' }}
            </p>
          </div>

          @if ($transaction->cover_path)
            <div class="sm:col-span-2">
              <p class="text-xs text-slate-500 mb-2">Bukti / Gambar</p>
              <div class="rounded-xl border border-slate-200 overflow-hidden w-full max-w-md">
                <img
                  src="{{ asset('storage/' . $transaction->cover_path) }}"
                  alt="Bukti transaksi"
                  class="w-full h-auto block">
              </div>
              <div class="mt-2 text-xs text-slate-400">
                <a href="{{ asset('storage/' . $transaction->cover_path) }}" target="_blank" class="underline hover:text-slate-600">
                  Lihat ukuran asli
                </a>
              </div>
            </div>
          @endif
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap items-center gap-2">
          <a href="{{ route('transactions.edit', $transaction) }}"
             class="inline-flex items-center h-10 px-4 rounded-lg text-sm bg-slate-100 text-slate-700 hover:bg-slate-200">
            Edit
          </a>
          <a href="{{ route('transactions.index') }}"
             class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700">
            Kembali
          </a>
          <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                onsubmit="return confirm('Hapus transaksi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center h-10 px-4 rounded-lg text-sm bg-rose-100 text-rose-700 hover:bg-rose-200">
              Hapus
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
