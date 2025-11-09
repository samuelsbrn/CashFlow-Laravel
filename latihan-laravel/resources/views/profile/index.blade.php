{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil')

@section('content')
  <div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-6 flex items-start justify-between gap-4">
      <div>
        <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase mb-1">Pengaturan</p>
        <h1 class="text-2xl font-semibold text-slate-900">Profil</h1>
        <p class="text-slate-500 text-sm">Kelola identitas akun dan kata sandi-mu.</p>
      </div>
      <div class="hidden md:flex items-center gap-3">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 text-brand-700 font-semibold">
          {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </span>
      </div>
    </div>

    {{-- Flash status (opsional, cocok dengan komponen #flash di layout) --}}
    @if (session('status'))
      <div id="flash" data-type="success" data-message="{{ session('status') }}"></div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      {{-- Kartu: Data Akun --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
          <div class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600/10 text-brand-700">
            {{-- icon user --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 12c4.418 0 8 2.239 8 5v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-1c0-2.761 3.582-5 8-5Z"/></svg>
          </div>
          <div>
            <h2 class="text-sm font-semibold text-slate-800">Data Akun</h2>
            <p class="text-xs text-slate-500">Nama & email untuk identitas login</p>
          </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1" for="name">Nama</label>
            <input
              id="name"
              type="text"
              name="name"
              value="{{ old('name', auth()->user()->name) }}"
              class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400"
              placeholder="Nama lengkap"
              required
              autocomplete="name"
            >
            @error('name')
              <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1" for="email">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email', auth()->user()->email) }}"
              class="w-full rounded-lg border-slate-200 focus:border-brand-500 focus:ring-brand-500/40 placeholder-slate-400"
              placeholder="nama@email.com"
              required
              autocomplete="email"
            >
            @error('email')
              <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-2 flex items-center justify-end gap-3">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-slate-700 bg-slate-100 hover:bg-slate-200">
              Batal
            </a>
            <button
              class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-brand-600 hover:bg-brand-700 shadow-sm">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      {{-- Kartu: Ganti Password --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
          <div class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900/10 text-slate-900">
            {{-- icon lock --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17 9h-1V7a4 4 0 1 0-8 0v2H7a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2Zm-6 6.732V17a1 1 0 1 0 2 0v-1.268a2 2 0 1 0-2 0ZM10 9V7a2 2 0 1 1 4 0v2h-4Z"/></svg>
          </div>
          <div>
            <h2 class="text-sm font-semibold text-slate-800">Ganti Password</h2>
            <p class="text-xs text-slate-500">Gunakan kata sandi yang kuat & unik</p>
          </div>
        </div>

        <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
          @csrf

          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1" for="current_password">Password sekarang</label>
            <input
              id="current_password"
              type="password"
              name="current_password"
              class="w-full rounded-lg border-slate-200 focus:border-slate-800 focus:ring-slate-800/40 placeholder-slate-400"
              placeholder="••••••••"
              autocomplete="current-password"
              required
            >
            @error('current_password')
              <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1" for="password">Password baru</label>
              <input
                id="password"
                type="password"
                name="password"
                class="w-full rounded-lg border-slate-200 focus:border-slate-800 focus:ring-slate-800/40 placeholder-slate-400"
                placeholder="Min. 8 karakter"
                autocomplete="new-password"
                required
              >
              @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1" for="password_confirmation">Konfirmasi password baru</label>
              <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="w-full rounded-lg border-slate-200 focus:border-slate-800 focus:ring-slate-800/40 placeholder-slate-400"
                placeholder="Ulangi password baru"
                autocomplete="new-password"
                required
              >
            </div>
          </div>

          <div class="pt-2 flex items-center justify-end gap-3">
            <button
              class="inline-flex items-center h-10 px-4 rounded-lg text-sm text-white bg-slate-800 hover:bg-slate-900 shadow-sm">
              Ubah Password
            </button>
          </div>

          <p class="text-[11px] text-slate-500 mt-2">
            Tips: kombinasikan huruf besar, kecil, angka & simbol. Jangan pakai ulang password dari layanan lain.
          </p>
        </form>
      </div>

    </div>
  </div>
@endsection
