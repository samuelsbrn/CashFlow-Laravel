@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
  <div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase mb-1">Pengelompokan</p>
        <h1 class="text-xl font-semibold text-slate-900">Kategori</h1>
        <p class="text-slate-500 text-sm">Kelola kategori agar transaksi lebih rapi.</p>
      </div>

      <a href="{{ route('categories.create') }}"
         class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ml-1" viewBox="0 0 20 20" fill="currentColor">
          <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
        </svg>
        Tambah
      </a>
    </div>

    {{-- Toolbar: search + info --}}
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <form method="GET" action="{{ route('categories.index') }}" class="w-full md:max-w-sm">
        <div class="relative">
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari kategori…"
            class="w-full rounded-lg border border-slate-300 pl-9 pr-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-200 outline-none transition"
          >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.387a1 1 0 01-1.414 1.414l-3.387-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
          </svg>
        </div>
      </form>

      @isset($categories)
        <div class="text-xs text-slate-500">
          Total: <span class="font-medium text-slate-700">{{ method_exists($categories,'total') ? $categories->total() : $categories->count() }}</span> kategori
        </div>
      @endisset
    </div>

    {{-- Card daftar kategori --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      @if(($categories instanceof \Illuminate\Contracts\Pagination\Paginator && $categories->count() === 0) || (is_iterable($categories) && count($categories) === 0))
        {{-- Empty state --}}
        <div class="px-6 py-16 text-center">
          <div class="mx-auto mb-4 w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
              <path d="M4 3a2 2 0 00-2 2v8.5A2.5 2.5 0 004.5 16H15a3 3 0 003-3V7a2 2 0 00-2-2h-5.586a2 2 0 01-1.414-.586L7.414 3H4z"/>
            </svg>
          </div>
          <h3 class="text-slate-900 font-semibold">Belum ada kategori</h3>
          <p class="text-slate-500 text-sm mt-1">Tambahkan kategori untuk mulai merapikan transaksi.</p>
          <a href="{{ route('categories.create') }}"
             class="mt-4 inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            Buat Kategori
          </a>
        </div>
      @else
        <table class="w-full text-sm">
          <thead class="bg-slate-50/80 text-left">
            <tr>
              <th class="px-5 py-3 text-slate-500 font-semibold">Nama</th>
              <th class="px-5 py-3 text-slate-500 font-semibold w-48">Warna</th>
              <th class="px-5 py-3 text-right w-40">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $cat)
              <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition">
                <td class="px-5 py-3">
                  <div class="flex items-center gap-2">
                    @php $dot = $cat->color ?? '#a855f7'; @endphp
                    <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $dot }}"></span>
                    <span class="text-slate-900 font-medium">{{ $cat->name }}</span>
                  </div>
                </td>
                <td class="px-5 py-3">
                  @php $color = $cat->color ?? '#a855f7'; @endphp
                  <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-md border border-slate-200" style="background: {{ $color }}"></span>
                    <code class="text-xs text-slate-500">{{ $color }}</code>
                  </div>
                </td>
                <td class="px-5 py-3">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('categories.edit', $cat) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-xs font-medium text-brand-700 hover:text-white hover:bg-brand-600 border border-brand-200 transition">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z" />
                        <path d="M11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                      </svg>
                      Edit
                    </a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline"
                          onsubmit="return confirm('Hapus kategori \"{{ $cat->name }}\"?')">
                      @csrf
                      @method('DELETE')
                      <button
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-xs font-medium text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h.293l.854 10.248A2 2 0 007.142 18h5.716a2 2 0 001.995-1.752L15.707 6H16a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zm-1 6a1 1 0 112 0v7a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v7a1 1 0 11-2 0V8z" clip-rule="evenodd"/>
                        </svg>
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- Pagination (jika pakai paginate) --}}
        @if(method_exists($categories, 'links'))
          <div class="px-5 py-3 bg-slate-50/60">
            {{ $categories->withQueryString()->links() }}
          </div>
        @endif
      @endif
    </div>
  </div>
@endsection
