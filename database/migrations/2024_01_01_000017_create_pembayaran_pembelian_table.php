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
        Schema::create('pembayaran_pembelian', function (Blueprint $table) {
            $table->id('idpembayaran_pembelian');
            $table->unsignedBigInteger('id_nota_beli');
            $table->dateTime('tanggal_bayar');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('metode_bayar', ['cash', 'transfer', 'credit']);

            $table->foreign('id_nota_beli')->references('id_nota_beli')->on('nota_beli')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pembelian');
    }
};