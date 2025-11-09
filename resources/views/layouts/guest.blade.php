{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Auth') · Latihan Laravel</title>

  {{-- Tailwind via CDN (tanpa Vite) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 300:'#a5b4fc',
              400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca',
              800:'#3730a3', 900:'#312e81'
            }
          },
          boxShadow: {
            card: '0 10px 30px -12px rgb(15 23 42 / 0.20)'
          }
        }
      }
    }
  </script>

  {{-- Prefer reduced motion --}}
  <style>
    @media (prefers-reduced-motion:no-preference){
      .fade-in{animation:fade .25s ease-out both}
      @keyframes fade{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
    }
  </style>

  @yield('head')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 text-slate-900 antialiased">

  {{-- Background dekor tipis --}}
  <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
    <div class="absolute -top-24 -right-24 w-[28rem] h-[28rem] rounded-full bg-brand-200/40 blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-[28rem] h-[28rem] rounded-full bg-indigo-200/40 blur-3xl"></div>
  </div>

  {{-- Wrapper --}}
  <div class="flex items-center justify-center p-6">
    <div class="w-full max-w-md fade-in">
      {{-- Logo / Brand --}}
      <div class="mb-6 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2">
          <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white font-bold">LL</span>
          <span class="text-lg font-semibold text-slate-800">Latihan <span class="text-brand-600">Laravel</span></span>
        </a>
      </div>

      {{-- Kartu konten auth --}}
      <div class="bg-white/90 backdrop-blur rounded-2xl border border-slate-200 shadow-card">
        <div class="p-6">
          @yield('content')
        </div>
      </div>

      {{-- Footer kecil --}}
      <p class="mt-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Latihan Laravel. Semua hak dilindungi.
      </p>
    </div>
  </div>

  {{-- Flash toast anchor --}}
  <div id="flash-root" class="fixed top-4 inset-x-0 z-50 flex justify-center px-4 pointer-events-none"></div>

  {{-- Auto-baca partial flash (#flash) jika dipakai --}}
  <script>
    (function(){
      const el = document.getElementById('flash');
      if(!el) return;
      showToast(el.dataset.message || '', el.dataset.type || 'info');
      el.remove();
    })();

    function showToast(message, type='info'){
      if(!message) return;
      const root = document.getElementById('flash-root');
      const color = {
        success:'bg-emerald-600',
        error:'bg-rose-600',
        warning:'bg-amber-600',
        info:'bg-slate-800'
      }[type] || 'bg-slate-800';

      const toast = document.createElement('div');
      toast.className = `pointer-events-auto ${color} text-white px-4 py-2 rounded-lg shadow-lg text-sm fade-in`;
      toast.textContent = message;
      root.appendChild(toast);
      setTimeout(()=>{ toast.style.transition='opacity .2s ease'; toast.style.opacity='0'; setTimeout(()=>toast.remove(),180); }, 2400);
    }
  </script>

  @yield('scripts')
</body>
</html>
