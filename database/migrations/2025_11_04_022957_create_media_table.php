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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // siapa yang upload
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // file ini milik transaksi mana
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();

            $table->string('disk')->default('public'); // misal 'public'
            $table->string('path');                    // misal 'covers/abc.png'
            $table->unsignedBigInteger('size')->nullable();
            $table->string('mime')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
