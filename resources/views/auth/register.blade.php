{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
  <div class="bg-white/90 backdrop-blur-sm border border-slate-200 shadow-lg rounded-2xl p-8">
    <div class="text-center mb-6">
      <div class="mx-auto w-14 h-14 flex items-center justify-center rounded-full bg-brand-100 mb-3">
        {{-- icon user plus --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-8 8a6 6 0 00-6 6m18 0a6 6 0 00-6-6M16 11h3m0 0h3m-3 0v-3m0 3v3"/>
        </svg>
      </div>
      <h1 class="text-2xl font-semibold text-slate-900">Buat Akun Baru</h1>
      <p class="text-sm text-slate-500 mt-1">Mulai kelola cash flow-mu sekarang</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('register.attempt') }}" class="space-y-5">
      @csrf

      <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
        <input
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition @error('name') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
          type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama lengkap">
        @error('name')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition @error('email') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
          type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@email.com">
        @error('email')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
        <div class="relative">
          <input
            class="w-full rounded-lg border border-slate-300 px-3 py-2 pr-10 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition @error('password') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
            type="password" id="password" name="password" required autocomplete="new-password" placeholder="Minimal 6 karakter">
          <button type="button" class="absolute inset-y-0 right-0 px-3 text-slate-500 hover:text-slate-700"
                  onclick="const i=document.getElementById('password'); i.type = i.type==='password' ? 'text':'password'">
            {{-- eye icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 3c-5 0-8 4.5-8 7s3 7 8 7 8-4.5 8-7-3-7-8-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
            </svg>
          </button>
        </div>
        @error('password')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
        <input
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition"
          type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
      </div>

      <button
        class="w-full inline-flex justify-center rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium py-2.5 shadow-sm transition">
        Daftar
      </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-600">
      Sudah punya akun?
      <a class="font-medium text-brand-700 hover:text-brand-800" href="{{ route('login') }}">Masuk</a>
    </p>
  </div>
@endsection
