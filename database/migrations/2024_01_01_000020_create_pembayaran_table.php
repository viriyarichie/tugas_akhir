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
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_nota_jual');
            $table->enum('metode_bayar', ['cash', 'qris', 'debit', 'kredit']);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->dateTime('tanggal_bayar');

            $table->foreign('id_nota_jual')->references('id_nota_jual')->on('nota_jual')->onDelete('cascade');
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