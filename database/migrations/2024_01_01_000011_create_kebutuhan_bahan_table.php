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
        Schema::create('kebutuhan_bahan', function (Blueprint $table) {
            $table->id('id_kebutuhan');
            $table->unsignedBigInteger('id_bahan');
            $table->unsignedBigInteger('id_prediksi');
            $table->decimal('jumlah_dibutuhkan', 14, 3);

            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->onDelete('cascade');
            $table->foreign('id_prediksi')->references('id_prediksi')->on('prediksi_penjualan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_bahan');
    }
};