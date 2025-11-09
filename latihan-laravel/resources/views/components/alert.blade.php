{{-- resources/views/components/flash.blade.php --}}
@if (session('success') || session('error') || session('warning') || session('info'))
  <div id="flash-wrapper"
       class="fixed top-5 right-5 z-50 space-y-2 max-w-sm animate-fade-in-up">

    @foreach (['success', 'error', 'warning', 'info'] as $type)
      @if (session($type))
        @php
          $colors = [
            'success' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => '✅'],
            'error'   => ['bg' => 'bg-rose-50',    'text' => 'text-rose-700',    'border' => 'border-rose-200',    'icon' => '⛔'],
            'warning' => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'icon' => '⚠️'],
            'info'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'border' => 'border-blue-200',    'icon' => 'ℹ️'],
          ];
        @endphp

        <div
          class="flash-item flex items-start gap-3 rounded-xl border {{ $colors[$type]['border'] }} {{ $colors[$type]['bg'] }} px-4 py-3 shadow-md backdrop-blur-sm"
          data-type="{{ $type }}">
          <div class="text-lg leading-none">{{ $colors[$type]['icon'] }}</div>
          <div class="flex-1 text-sm {{ $colors[$type]['text'] }}">
            {!! nl2br(e(session($type))) !!}
          </div>
          <button
            type="button"
            class="text-slate-400 hover:text-slate-600 text-xs font-medium"
            onclick="this.parentElement.remove()">
            ✕
          </button>
        </div>
      @endif
    @endforeach
  </div>

  <script>
    // Auto-hide after 4 seconds
    setTimeout(() => {
      document.querySelectorAll('.flash-item').forEach(el => {
        el.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => el.remove(), 500);
      });
    }, 4000);
  </script>

  <style>
    @keyframes fade-in-up {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up > .flash-item {
      animation: fade-in-up 0.3s ease-out both;
    }
    .flash-item {
      transition: all .4s ease;
    }
  </style>
@endif
