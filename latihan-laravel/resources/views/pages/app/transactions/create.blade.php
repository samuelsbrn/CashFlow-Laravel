@extends('layouts.app')
@section('content')
  <div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Tambah Transaksi</h1>
    @livewire('transaction-form')
  </div>
@endsection
