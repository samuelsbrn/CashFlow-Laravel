{{-- resources/views/components/pagination.blade.php --}}
@if ($paginator->hasPages())
  <div class="flex flex-col items-center justify-center gap-3 mt-8">
    {{-- Info halaman --}}
    <div class="text-xs text-slate-500">
      Halaman <span class="font-medium text-slate-700">{{ $paginator->currentPage() }}</span>
      dari <span class="font-medium text-slate-700">{{ $paginator->lastPage() }}</span>
    </div>

    {{-- Navigasi --}}
    <div class="flex items-center gap-2">
      {{-- Tombol Sebelumnya --}}
      @if ($paginator->onFirstPage())
        <span
          class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm rounded-md border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed select-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          Sebelumnya
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm rounded-md border border-slate-200 text-slate-600 hover:border-brand-500 hover:text-brand-600 bg-white transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          Sebelumnya
        </a>
      @endif

      {{-- Nomor halaman kecil (opsional) --}}
      <div class="flex items-center gap-1 text-sm">
        @foreach ($elements as $element)
          @if (is_string($element))
            <span class="px-2 text-slate-400">…</span>
          @endif

          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <span
                  class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-brand-600 text-white text-sm font-semibold">
                  {{ $page }}
                </span>
              @else
                <a href="{{ $url }}"
                   class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 text-slate-600 hover:text-brand-600 hover:border-brand-500 transition">
                  {{ $page }}
                </a>
              @endif
            @endforeach
          @endif
        @endforeach
      </div>

      {{-- Tombol Selanjutnya --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm rounded-md border border-slate-200 text-slate-600 hover:border-brand-500 hover:text-brand-600 bg-white transition">
          Selanjutnya
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </a>
      @else
        <span
          class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm rounded-md border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed select-none">
          Selanjutnya
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      @endif
    </div>
  </div>
@endif
