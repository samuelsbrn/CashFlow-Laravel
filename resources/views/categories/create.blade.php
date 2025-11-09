@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
  <div class="max-w-xl mx-auto">
    {{-- Header --}}
    <div class="mb-4 flex items-center justify-between">
      <a href="{{ route('categories.index') }}"
         class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
          <path d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L8.414 9H16a1 1 0 110 2H8.414l3.293 3.293a1 1 0 010 1.414z"/>
        </svg>
        Kembali
      </a>
    </div>

    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200 p-6">
      <div class="mb-5">
        <h2 class="text-lg font-semibold text-slate-900">Tambah Kategori</h2>
        <p class="text-sm text-slate-500 mt-1">Beri nama dan warna agar mudah dikenali di transaksi.</p>
      </div>

      <form action="{{ route('categories.store') }}" method="POST" class="space-y-5" novalidate>
        @csrf

        {{-- Nama --}}
        <div>
          <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
            Nama Kategori <span class="text-rose-500">*</span>
          </label>
          <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
            required
            placeholder="Contoh: Makan, Transportasi, Gaji"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition @error('name') border-rose-400 focus:border-rose-500 focus:ring-rose-200 @enderror">
          @error('name')
            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
          @else
            <p class="mt-2 text-xs text-slate-500">Gunakan nama singkat & jelas. Misal: <em>Groceries</em>, <em>Tagihan</em>, <em>Hiburan</em>.</p>
          @enderror
        </div>

        {{-- Warna --}}
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">
            Warna (opsional)
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            {{-- Picker besar --}}
            <div class="sm:col-span-1">
              <div class="flex items-center gap-3">
                <input
                  type="color"
                  name="color"
                  id="color"
                  value="{{ old('color', '#6366f1') }}"
                  class="w-12 h-12 rounded-lg border border-slate-200 cursor-pointer p-0">
                <div>
                  <p class="text-xs text-slate-500">Pilih warna utama kategori.</p>
                  <div class="mt-2 inline-flex items-center gap-2">
                    <span class="text-xs text-slate-500">HEX</span>
                    <input
                      type="text"
                      id="colorHex"
                      value="{{ old('color', '#6366f1') }}"
                      class="w-28 rounded-md border border-slate-300 px-2 py-1 text-xs font-mono focus:border-brand-500 focus:ring-brand-200 outline-none transition">
                  </div>
                </div>
              </div>
            </div>

            {{-- Quick picks --}}
            <div class="sm:col-span-2">
              <div class="text-xs text-slate-500 mb-2">Atau pilih cepat:</div>
              <div class="flex flex-wrap gap-2">
                @php
                  $swatches = ['#6366f1','#22c55e','#ef4444','#f59e0b','#06b6d4','#84cc16','#ec4899','#0ea5e9','#a855f7','#f43f5e'];
                @endphp
                @foreach($swatches as $hex)
                  <button type="button"
                          data-hex="{{ $hex }}"
                          class="swatch w-8 h-8 rounded-lg border border-slate-200"
                          style="background: {{ $hex }};"
                          title="{{ $hex }}"></button>
                @endforeach
              </div>

              {{-- Preview chip --}}
              <div class="mt-4">
                <div id="chipPreview"
                     class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium"
                     style="background: {{ old('color', '#6366f1') }}; color: white;">
                  <span class="inline-block w-2 h-2 rounded-full bg-white/80"></span>
                  <span>Preview kategori</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <div class="pt-2 flex items-center gap-3">
          <button type="submit"
                  class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path d="M4 3a2 2 0 00-2 2v2h16V5a2 2 0 00-2-2H4z" />
              <path fill-rule="evenodd" d="M18 9H2v6a2 2 0 002 2h12a2 2 0 002-2V9zM7 11a1 1 0 012 0v4H7v-4zm4 0a1 1 0 112 0v4h-2v-4z" clip-rule="evenodd"/>
            </svg>
            Simpan
          </button>

          <a href="{{ route('categories.index') }}"
             class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- sinkronisasi picker <-> hex + swatch + preview --}}
  <script>
    const inputColor = document.getElementById('color');
    const inputHex   = document.getElementById('colorHex');
    const chip       = document.getElementById('chipPreview');
    const swatches   = document.querySelectorAll('.swatch');

    function isValidHex(hex) {
      return /^#([0-9A-Fa-f]{6})$/.test(hex);
    }
    function applyColor(hex) {
      if (!isValidHex(hex)) return;
      inputColor.value = hex;
      inputHex.value   = hex;
      chip.style.background = hex;
    }

    inputColor?.addEventListener('input', (e) => applyColor(e.target.value));
    inputHex?.addEventListener('input', (e) => {
      const val = e.target.value.startsWith('#') ? e.target.value : '#'+e.target.value;
      if (isValidHex(val)) applyColor(val);
    });
    swatches?.forEach(btn => btn.addEventListener('click', () => applyColor(btn.dataset.hex)));
  </script>
@endsection
