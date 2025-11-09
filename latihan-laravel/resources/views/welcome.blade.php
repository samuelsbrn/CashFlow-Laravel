{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  @php
      $income      = $income      ?? 0;
      $expense     = $expense     ?? 0;
      $balance     = $balance     ?? 0;
      $labels      = $labels      ?? [];
      $incomeData  = $incomeData  ?? [];
      $expenseData = $expenseData ?? [];

      $monthName = \Carbon\Carbon::now()->translatedFormat('F Y');
      $balancePositive = $balance >= 0;
  @endphp

  <div class="max-w-6xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-6">
      <div>
        <p class="text-[11px] tracking-wide text-brand-600 font-semibold uppercase">Ringkasan</p>
        <h1 class="text-2xl font-semibold text-slate-900">Dashboard Keuangan</h1>
        <p class="text-slate-500 text-sm">Rekap bulan {{ $monthName }}</p>
      </div>
      <div class="hidden sm:flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600">
        {{-- ikon kalender --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <rect x="3" y="4" width="18" height="18" rx="2" class="stroke-slate-400"/>
          <path d="M16 2v4M8 2v4M3 10h18" class="stroke-slate-400"/>
        </svg>
        <span>{{ now()->translatedFormat('l, d M Y') }}</span>
      </div>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
      {{-- Income --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
          <h2 class="text-sm tracking-wide text-slate-500 font-medium">Total Pemasukan</h2>
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
            {{-- icon arrow down-left (masuk) --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M19 5L5 19M5 19V8M5 19h11" />
            </svg>
          </span>
        </div>
        <p class="text-3xl font-semibold mt-2 text-slate-900">Rp {{ number_format($income, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Seluruh pemasukan yang tercatat.</p>
      </div>

      {{-- Expense --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
          <h2 class="text-sm tracking-wide text-slate-500 font-medium">Total Pengeluaran</h2>
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
            {{-- icon arrow up-right (keluar) --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M5 19L19 5M19 5v11M19 5H8" />
            </svg>
          </span>
        </div>
        <p class="text-3xl font-semibold mt-2 text-slate-900">Rp {{ number_format($expense, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Seluruh transaksi keluar.</p>
      </div>

      {{-- Balance --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
          <h2 class="text-sm tracking-wide text-slate-500 font-medium">Saldo</h2>
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl {{ $balancePositive ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
            {{-- icon wallet --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M3 7h14a4 4 0 0 1 4 4v4a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7Z" />
              <path d="M16 7V5a2 2 0 0 0-2-2H7" />
            </svg>
          </span>
        </div>
        <p class="text-3xl font-semibold mt-2 {{ $balancePositive ? 'text-slate-900' : 'text-amber-700' }}">
          Rp {{ number_format($balance, 0, ',', '.') }}
        </p>
        <p class="text-xs text-slate-400 mt-1">Pemasukan dikurangi pengeluaran.</p>
      </div>
    </div>

    {{-- Chart Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h3 class="text-lg font-semibold text-slate-900">Grafik Pemasukan & Pengeluaran</h3>
          <p class="text-xs text-slate-400">Rekap per bulan</p>
        </div>
        {{-- Legend badges (kecil) --}}
        <div class="hidden sm:flex items-center gap-3 text-xs">
          <span class="inline-flex items-center gap-2 text-slate-600">
            <span class="w-3 h-3 rounded-full" style="background: rgba(37,99,235,.7)"></span> Pemasukan
          </span>
          <span class="inline-flex items-center gap-2 text-slate-600">
            <span class="w-3 h-3 rounded-full" style="background: rgba(220,38,38,.7)"></span> Pengeluaran
          </span>
        </div>
      </div>

      @if (count($labels))
        <div class="w-full" style="min-height: 260px;">
          <canvas id="incomeExpenseChart" height="130"></canvas>
        </div>
      @else
        <div class="text-sm text-slate-500 p-4 border border-dashed border-slate-200 rounded-xl">
          Belum ada data untuk ditampilkan.
        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  @if(count($labels))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const labels      = @json($labels);
      const incomeData  = @json($incomeData);
      const expenseData = @json($expenseData);

      const ctx = document.getElementById('incomeExpenseChart').getContext('2d');

      // Gradient fill untuk dua garis (lebih lembut)
      const grdIncome  = ctx.createLinearGradient(0, 0, 0, 240);
      grdIncome.addColorStop(0, 'rgba(37,99,235,.18)');
      grdIncome.addColorStop(1, 'rgba(37,99,235,0)');

      const grdExpense = ctx.createLinearGradient(0, 0, 0, 240);
      grdExpense.addColorStop(0, 'rgba(220,38,38,.18)');
      grdExpense.addColorStop(1, 'rgba(220,38,38,0)');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [
            {
              label: 'Pemasukan',
              data: incomeData,
              borderColor: '#2563eb',
              backgroundColor: grdIncome,
              borderWidth: 2,
              tension: .35,
              pointRadius: 2.5,
              pointHoverRadius: 4,
              fill: true
            },
            {
              label: 'Pengeluaran',
              data: expenseData,
              borderColor: '#dc2626',
              backgroundColor: grdExpense,
              borderWidth: 2,
              tension: .35,
              pointRadius: 2.5,
              pointHoverRadius: 4,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { intersect: false, mode: 'index' },
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: 'rgba(15,23,42,.95)',
              titleColor: '#fff',
              bodyColor: '#cbd5e1',
              padding: 10,
              displayColors: false,
              callbacks: {
                label: (ctx) => `${ctx.dataset.label}: Rp ${new Intl.NumberFormat('id-ID').format(ctx.raw ?? 0)}`
              }
            }
          },
          scales: {
            x: {
              grid: { display: false },
              ticks: { color: '#94a3b8' }
            },
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(148,163,184,.15)' },
              ticks: {
                color: '#94a3b8',
                callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
              }
            }
          }
        }
      });
    </script>
  @endif
@endsection
