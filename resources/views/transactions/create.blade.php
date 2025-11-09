{{-- resources/views/transactions/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
  <div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-6">
      <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase mb-1">Transaksi</p>
      <h1 class="text-2xl font-semibold text-slate-900">Tambah Transaksi</h1>
      <p class="text-slate-500 text-sm">Catat pemasukan atau pengeluaran baru dengan detail yang lengkap.</p>
    </div>

    {{-- Kartu Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <form action="{{ route('transactions.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6 space-y-5">
        @csrf

        {{-- Judul --}}
        <div>
          <label for="title" class="block text-xs font-medium text-slate-600 mb-1">Judul / Nama Transaksi</label>
          <input type="text"
                 id="title"
                 name="title"
                 value="{{ old('title') }}"
                 class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400"
                 placeholder="Contoh: Gaji Bulanan, Beli Makan Siang"
                 required>
          @error('title')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Jenis --}}
        <div>
          <label for="type" class="block text-xs font-medium text-slate-600 mb-1">Jenis Transaksi</label>
          <select id="type" name="type"
                  class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-slate-700 text-sm">
            <option value="income" @selected(old('type') === 'income')>Pemasukan</option>
            <option value="expense" @selected(old('type') === 'expense')>Pengeluaran</option>
          </select>
        </div>

        {{-- Jumlah --}}
        <div>
          <label for="amount" class="block text-xs font-medium text-slate-600 mb-1">Jumlah</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">Rp</span>
            <input type="number"
                   id="amount"
                   name="amount"
                   min="0"
                   value="{{ old('amount') }}"
                   class="w-full pl-8 rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400"
                   placeholder="0"
                   required>
          </div>
          @error('amount')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Kategori --}}
        <div>
          <label for="category_id" class="block text-xs font-medium text-slate-600 mb-1">Kategori</label>
          <select id="category_id" name="category_id"
                  class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-slate-700 text-sm">
            <option value="">-- Tanpa kategori --</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Deskripsi --}}
        <div>
          <label for="description" class="block text-xs font-medium text-slate-600 mb-1">Deskripsi / Catatan</label>
          <textarea id="description"
                    name="description"
                    rows="2"
                    class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400 text-sm"
                    placeholder="Tulis catatan kecil (opsional)">{{ old('description') }}</textarea>
        </div>

        {{-- Tanggal --}}
        <div>
          <label for="occurred_at" class="block text-xs font-medium text-slate-600 mb-1">Tanggal</label>
          <input type="date"
                 id="occurred_at"
                 name="occurred_at"
                 value="{{ old('occurred_at', now()->toDateString()) }}"
                 class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 text-slate-700 text-sm">
        </div>

        {{-- Bukti / Gambar --}}
        <div>
          <label for="cover" class="block text-xs font-medium text-slate-600 mb-1">Bukti / Gambar</label>
          <input type="file"
                 id="cover"
                 name="cover"
                 accept="image/*"
                 class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-brand-600 file:text-white file:text-sm hover:file:bg-brand-700">
          <p class="text-xs text-slate-400 mt-1">JPG/PNG maks 2 MB. Opsional.</p>
          @error('cover')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="pt-4 flex items-center justify-end gap-3">
          <a href="{{ route('transactions.index') }}"
             class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-slate-700 bg-slate-100 hover:bg-slate-200">
            Batal
          </a>
          <button type="submit"
                  class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700 shadow-sm">
            Simpan Transaksi
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
