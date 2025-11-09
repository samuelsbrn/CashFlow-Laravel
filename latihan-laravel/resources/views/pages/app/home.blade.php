@extends('layouts.app')
@section('content')
  <div class="grid md:grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow"><div id="chart-income-expense"></div></div>
    <div class="bg-white p-4 rounded shadow"><div id="chart-category"></div></div>
  </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  new ApexCharts(document.querySelector('#chart-income-expense'), {
    chart:{type:'area',height:320},
    series:[
      {name:'Income', data: @json($income ?? [])},
      {name:'Expense', data: @json($expense ?? [])},
    ],
    xaxis:{ categories: @json($months ?? []) },
  }).render();

  new ApexCharts(document.querySelector('#chart-category'), {
    chart:{type:'donut',height:320},
    labels: @json($pieLabels ?? []),
    series: @json($pieSeries ?? []),
  }).render();
</script>
@endpush
