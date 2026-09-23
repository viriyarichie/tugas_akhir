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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_jual_id')->constrained('nota_jual')->cascadeOnDelete();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->date('tgl_bayar');
            $table->string('metode', 50); // e.g. cash, qris, transfer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};