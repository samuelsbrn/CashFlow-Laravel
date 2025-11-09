@extends('layouts.app')
@section('content')
  <div class="bg-white p-4 rounded shadow">
    @if($transaction->cover)
      <img src="{{ Storage::url($transaction->cover) }}" class="w-40 h-40 object-cover rounded mb-3"/>
    @endif
    <div class="text-xl font-semibold">{{ $transaction->title }}</div>
    <div class="text-sm text-gray-500">
      {{ $transaction->transacted_at->format('d M Y') }} • Rp{{ number_format($transaction->amount,0,',','.') }} • {{ $transaction->type }}
    </div>
    <div class="prose max-w-none mt-3">{!! $transaction->description !!}</div>
  </div>
@endsection
