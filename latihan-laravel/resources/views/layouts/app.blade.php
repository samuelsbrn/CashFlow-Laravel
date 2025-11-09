{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','App') · CashFlow</title>

  {{-- Tailwind via CDN (tanpa Vite) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          container: { center: true, padding: '1rem' },
          colors: {
            brand: {
              50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',
              400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',
              800:'#3730a3',900:'#312e81'
            }
          },
          boxShadow: {
            header: '0 1px 0 0 rgb(226 232 240 / 1), 0 4px 16px -8px rgb(15 23 42 / 0.08)'
          }
        }
      }
    }
  </script>

  {{-- Helper kecil untuk set link aktif --}}
  @php
    function nav_active($name) {
      return request()->routeIs($name) ? 'text-brand-700' : 'text-slate-600';
    }
    function pill_active($name) {
      return request()->routeIs($name)
        ? 'bg-slate-900 text-white'
        : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100';
    }
  @endphp

  @yield('head')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">

  {{-- Topbar --}}
  <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200 shadow-header">
    <div class="max-w-6xl mx-auto px-4">
      <div class="h-14 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button id="btnMobile"
                  class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 hover:bg-slate-50"
                  aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>

          <a href="{{ route('dashboard') }}" class="font-semibold text-slate-900">
            Cash <span class="text-brand-600">Flow</span>
          </a>

          {{-- Pills nav (desktop) --}}
          <nav class="hidden md:flex items-center gap-1 ml-6">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center h-9 px-3 rounded-full text-sm transition {{ pill_active('dashboard') }}">
              Dashboard
            </a>
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center h-9 px-3 rounded-full text-sm transition {{ pill_active('categories.index') }}">
              Kategori
            </a>
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center h-9 px-3 rounded-full text-sm transition {{ pill_active('transactions.index') }}">
              Transaksi
            </a>
          </nav>
        </div>

        {{-- Right actions --}}
        <div class="flex items-center gap-2">
          {{-- (opsional) quick search --}}
          <form action="#" class="hidden md:flex">
            <label class="relative">
              <input type="search" placeholder="Cari…"
                     class="peer w-56 rounded-lg border border-slate-200 bg-white/60 px-9 py-2 text-sm
                            placeholder-slate-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 outline-none transition">
              <svg class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-slate-400 peer-focus:text-brand-600"
                   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 105.02 13.13l3.67 3.67a.75.75 0 101.06-1.06l-3.67-3.67A7.5 7.5 0 0010.5 3zm-6 7.5a6 6 0 1112 0 6 6 0 01-12 0z" clip-rule="evenodd"/>
              </svg>
            </label>
          </form>

          {{-- Logout --}}
          <form action="{{ route('logout') }}" method="POST" class="ml-1">
            @csrf
            <button
              class="inline-flex items-center gap-2 h-9 px-3 rounded-lg text-sm border border-slate-200
                     hover:border-rose-300 text-rose-600 hover:bg-rose-50 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 3a1 1 0 00-1 1v3a1 1 0 102 0V5h6v14h-6v-2a1 1 0 10-2 0v3a1 1 0 001 1h8a1 1 0 001-1V4a1 1 0 00-1-1h-8z"/>
                <path d="M13.293 14.707a1 1 0 010-1.414L14.586 12l-1.293-1.293a1 1 0 111.414-1.414l2 2a1 1 0 010 1.414l-2 2a1 1 0 01-1.414 0zM3 12a1 1 0 011-1h9a1 1 0 110 2H4a1 1 0 01-1-1z"/>
              </svg>
              Keluar
            </button>
          </form>
        </div>
      </div>

      {{-- Mobile menu --}}
      <nav id="mobileMenu" class="md:hidden hidden pb-3">
        <div class="mt-2 grid gap-1">
          <a href="{{ route('dashboard') }}"
             class="block rounded-lg px-3 py-2 text-sm {{ nav_active('dashboard') }} hover:bg-slate-100">Dashboard</a>
          <a href="{{ route('categories.index') }}"
             class="block rounded-lg px-3 py-2 text-sm {{ nav_active('categories.index') }} hover:bg-slate-100">Kategori</a>
          <a href="{{ route('transactions.index') }}"
             class="block rounded-lg px-3 py-2 text-sm {{ nav_active('transactions.index') }} hover:bg-slate-100">Transaksi</a>
        </div>
      </nav>
    </div>
  </header>

  {{-- Flash alert (otomatis dari session) --}}
  <div id="flash-root" class="fixed top-16 inset-x-0 z-40 flex justify-center px-4 pointer-events-none"></div>

  {{-- Isi halaman --}}
  <main class="py-8">
    <div class="max-w-6xl mx-auto px-4">
      @yield('content')
    </div>
  </main>

  {{-- Footer kecil --}}
  <footer class="border-t border-slate-200 py-6">
    <div class="max-w-6xl mx-auto px-4 text-xs text-slate-500">
      &copy; {{ date('Y') }} Latihan Laravel — Dibuat dengan ♥
    </div>
  </footer>

  {{-- Script kecil untuk mobile toggle & flash --}}
  <script>
    const btn = document.getElementById('btnMobile');
    const menu = document.getElementById('mobileMenu');
    if (btn && menu) {
      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    }

    // Baca flash dari #flash (jika kamu pakai partial yang sudah kita buat sebelumnya)
    const flashDiv = document.getElementById('flash');
    if (flashDiv) {
      const type = flashDiv.dataset.type || 'info';
      const message = flashDiv.dataset.message || '';
      showToast(message, type);
      flashDiv.remove();
    }

    function showToast(message, type = 'info') {
      if (!message) return;
      const root = document.getElementById('flash-root');
      const colors = {
        success: 'bg-emerald-500',
        error: 'bg-rose-500',
        warning: 'bg-amber-500',
        info: 'bg-slate-700'
      };
      const el = document.createElement('div');
      el.className = `pointer-events-auto ${colors[type] || colors.info} text-white rounded-lg shadow-lg px-4 py-2 text-sm
                      animate-[fadeIn_.2s_ease-out_forwards]`;
      el.textContent = message;
      root.appendChild(el);
      setTimeout(() => {
        el.classList.add('animate-[fadeOut_.2s_ease-in_forwards]');
        setTimeout(() => el.remove(), 180);
      }, 2400);
    }
  </script>
  <style>
    @keyframes fadeIn { from {opacity:0; transform: translateY(-4px)} to {opacity:1; transform:translateY(0)} }
    @keyframes fadeOut { from {opacity:1; transform: translateY(0)} to {opacity:0; transform:translateY(-4px)} }
  </style>

  @yield('scripts')
</body>
</html>
