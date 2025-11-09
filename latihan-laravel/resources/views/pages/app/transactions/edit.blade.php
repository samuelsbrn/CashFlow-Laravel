@extends('layouts.app')
@section('content')
  <div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Ubah Transaksi</h1>
    @livewire('transaction-form', ['transactionId' => $transaction->id])
  </div>
@endsection
