{{-- resources/views/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
  <div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase mb-1">Transaksi</p>
        <h1 class="text-2xl font-semibold text-slate-900">Daftar Transaksi</h1>
        <p class="text-slate-500 text-sm">Semua pemasukan dan pengeluaranmu ada di sini.</p>
      </div>
      <a href="{{ route('transactions.create') }}"
         class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700 shadow-sm">
        + Tambah Transaksi
      </a>
    </div>

    {{-- Filter Bar --}}
    @php
      $hasFilters = request('q') || request('type') || request('category_id') || request('date_from') || request('date_to');
    @endphp
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
      <form action="{{ route('transactions.index') }}" method="GET" class="p-4 grid grid-cols-1 md:grid-cols-5 gap-3">
        {{-- Cari --}}
        <div class="md:col-span-2">
          <label class="block text-xs font-medium text-slate-600 mb-1">Cari</label>
          <input type="text" name="q" value="{{ request('q') }}"
                 class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400"
                 placeholder="Judul / catatan...">
        </div>
        {{-- Tipe --}}
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Tipe</label>
          <select name="type"
                  class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-sm">
            <option value="">Semua tipe</option>
            <option value="income"  @selected(request('type')==='income')>Pemasukan</option>
            <option value="expense" @selected(request('type')==='expense')>Pengeluaran</option>
          </select>
        </div>
        {{-- Kategori --}}
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Kategori</label>
          <select name="category_id"
                  class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-sm">
            <option value="">Semua kategori</option>
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        {{-- Rentang Tanggal --}}
        <div class="md:col-span-5 grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Dari</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-sm">
          </div>
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Sampai</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-sm">
          </div>
          <div class="flex items-end gap-3">
            <button class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700">
              Terapkan
            </button>
            @if($hasFilters)
              <a href="{{ route('transactions.index') }}"
                 class="inline-flex items-center h-10 px-4 rounded-lg text-sm bg-slate-100 text-slate-700 hover:bg-slate-200">
                Reset
              </a>
            @endif
          </div>
        </div>
      </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-slate-50 text-slate-600">
              <th class="text-left px-5 py-3 font-semibold">Tanggal</th>
              <th class="text-left px-5 py-3 font-semibold">Judul / Catatan</th>
              <th class="text-left px-5 py-3 font-semibold">Kategori</th>
              <th class="text-left px-5 py-3 font-semibold">Tipe</th>
              <th class="text-right px-5 py-3 font-semibold">Nominal</th>
              <th class="text-right px-5 py-3 font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($transactions as $tx)
              @php
                $isIncome = $tx->type === 'income';
                $color    = $tx->category->color ?? '#a78bfa';
              @endphp
              <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition">
                <td class="px-5 py-3 text-slate-700">
                  {{ \Carbon\Carbon::parse($tx->occurred_at)->format('d M Y') }}
                </td>

                <td class="px-5 py-3">
                  <a href="{{ route('transactions.show', $tx) }}"
                     class="font-medium text-slate-900 hover:text-brand-700">
                    {{ $tx->title ?? ($tx->description ?? '-') }}
                  </a>
                  @if($tx->description)
                    <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $tx->description }}</div>
                  @endif
                </td>

                <td class="px-5 py-3">
                  <div class="inline-flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full border border-slate-200" style="background: {{ $color }}"></span>
                    <span class="text-slate-700">{{ $tx->category->name ?? 'Tanpa Kategori' }}</span>
                  </div>
                </td>

                <td class="px-5 py-3">
                  @if ($isIncome)
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 text-xs">
                      <span class="text-emerald-500">●</span> Pemasukan
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 text-rose-700 border border-rose-100 px-2 py-0.5 text-xs">
                      <span class="text-rose-500">●</span> Pengeluaran
                    </span>
                  @endif
                </td>

                <td class="px-5 py-3 text-right">
                  @if ($isIncome)
                    <span class="font-medium text-emerald-600">+ Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                  @else
                    <span class="font-medium text-rose-600">- Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                  @endif
                </td>

                <td class="px-5 py-3">
                  <div class="flex justify-end gap-2">
                    <a href="{{ route('transactions.edit', $tx) }}"
                       class="inline-flex items-center h-8 px-3 rounded-md text-xs bg-slate-100 text-slate-700 hover:bg-slate-200">
                      Edit
                    </a>
                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST"
                          onsubmit="return confirm('Hapus transaksi ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center h-8 px-3 rounded-md text-xs bg-rose-100 text-rose-700 hover:bg-rose-200">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-5 py-10 text-center">
                  <div class="mx-auto w-full sm:w-[400px]">
                    <div class="rounded-xl border border-dashed border-slate-300 p-6">
                      <p class="text-slate-500">Belum ada transaksi. Mulai dengan menambahkan transaksi pertama.</p>
                      <a href="{{ route('transactions.create') }}"
                         class="mt-3 inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700">
                        + Tambah Transaksi
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if(method_exists($transactions, 'links'))
        <div class="px-5 py-4 bg-slate-50/60">
          {{ $transactions->appends(request()->query())->links() }}
        </div>
      @endif
    </div>
  </div>
@endsection
