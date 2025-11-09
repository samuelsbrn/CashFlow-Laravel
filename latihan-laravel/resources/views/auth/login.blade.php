{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Masuk ke Akun')

@section('content')
  <div class="bg-white/90 backdrop-blur-sm border border-slate-200 shadow-lg rounded-2xl p-8">
    <div class="text-center mb-6">
      <div class="mx-auto w-14 h-14 flex items-center justify-center rounded-full bg-brand-100 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12H8m0 0l4-4m-4 4l4 4m8-8v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h12a2 2 0 012 2z" />
        </svg>
      </div>
      <h1 class="text-2xl font-semibold text-slate-900">Selamat Datang </h1>
      <p class="text-sm text-slate-500 mt-1">Masuk untuk melanjutkan ke dashboard</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition"
          type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
          placeholder="contoh@email.com">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
        <input
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand-500 focus:ring focus:ring-brand-200 outline-none transition"
          type="password" id="password" name="password" required autocomplete="current-password"
          placeholder="••••••••">
      </div>

      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2 text-slate-600">
          <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
          Ingat saya
        </label>
        <a href="#" class="text-brand-600 hover:text-brand-700">Lupa password?</a>
      </div>

      <button
        class="w-full inline-flex justify-center rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium py-2.5 shadow-sm transition">
        Masuk
      </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-600">
      Belum punya akun?
      <a class="font-medium text-brand-700 hover:text-brand-800" href="{{ route('register') }}">Daftar Sekarang</a>
    </p>
  </div>
@endsection
