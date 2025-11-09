<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // pemilik transaksi
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // JANGAN bikin category_id di sini, nanti ditambah di migration lain

            // pemasukan atau pengeluaran
            $table->enum('type', ['income', 'expense']);

            $table->string('title');
            $table->text('note')->nullable();

            // nominal uang
            $table->decimal('amount', 14, 2);

            // tanggal kejadian transaksi
            $table->date('occurred_at');

            // simpan path gambar cover kalau ada upload
            $table->string('cover_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
