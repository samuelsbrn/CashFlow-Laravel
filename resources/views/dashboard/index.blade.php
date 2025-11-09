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
@endphp

<div class="max-w-6xl mx-auto px-4">
  {{-- Kartu ringkas --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-5">
      <p class="text-xs tracking-wide text-slate-500 font-medium">Total Pemasukan</p>
      <p class="text-2xl font-bold mt-1">Rp {{ number_format($income, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-5">
      <p class="text-xs tracking-wide text-slate-500 font-medium">Total Pengeluaran</p>
      <p class="text-2xl font-bold mt-1">Rp {{ number_format($expense, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-5">
      <p class="text-xs tracking-wide text-slate-500 font-medium">Saldo</p>
      <p class="text-2xl font-bold mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>
  </div>

  {{-- Statistik (ApexCharts) --}}
  <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-5">
    <div class="mb-4">
      <h3 class="text-lg font-semibold">Grafik Pemasukan & Pengeluaran</h3>
      <p class="text-xs text-slate-400">Rekap per bulan</p>
    </div>

    @if (count($labels))
      <div id="incomeExpenseChart" style="width:100%;min-height:320px;"></div>
    @else
      <div class="text-sm text-slate-500 p-4 border border-dashed border-slate-200 rounded-lg">
        Belum ada data untuk ditampilkan.
      </div>
    @endif
  </div>
</div>
@endsection

@section('scripts')
@if (count($labels))
  {{-- ApexCharts CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    // Data dari controller
    const labels      = @json($labels);
    const incomeData  = @json($incomeData);
    const expenseData = @json($expenseData);

    // Formatter Rupiah
    const rupiah = (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v ?? 0);

    const options = {
      series: [
        { name: 'Pemasukan',  data: incomeData },
        { name: 'Pengeluaran', data: expenseData }
      ],
      chart: {
        type: 'area',
        height: 320,
        toolbar: {
          show: true,
          tools: {
            download: true, selection: true, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true
          }
        }
      },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
      colors: ['#2563eb', '#dc2626'],
      fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 0.7, opacityFrom: 0.15, opacityTo: 0.02, stops: [0, 90, 100] }
      },
      grid: {
        borderColor: '#e2e8f0',
        strokeDashArray: 4,
        padding: { left: 10, right: 10 }
      },
      xaxis: {
        categories: labels,
        labels: { rotate: -15 },
        tooltip: { enabled: false }
      },
      yaxis: {
        labels: { formatter: rupiah }
      },
      legend: { position: 'top', horizontalAlign: 'left' },
      tooltip: {
        shared: true,
        intersect: false,
        y: { formatter: rupiah }
      },
      markers: {
        size: 0,
        hover: { size: 5 }
      },
      responsive: [
        {
          breakpoint: 640,
          options: {
            chart: { height: 280 },
            xaxis: { labels: { rotate: -30 } }
          }
        }
      ]
    };

    const chart = new ApexCharts(document.querySelector('#incomeExpenseChart'), options);
    chart.render();
  </script>
@endif
@endsection
