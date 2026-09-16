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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');
            $table->unsignedBigInteger('id_nota_beli');
            $table->unsignedBigInteger('id_bahan');
            $table->decimal('jumlah_input', 14, 3);
            $table->string('satuan_input', 3);
            $table->decimal('jumlah_konversi', 14, 3);

            $table->foreign('id_nota_beli')->references('id_nota_beli')->on('nota_beli')->onDelete('cascade');
            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->onDelete('cascade');
            // Assuming satuan_input could be a reference, if so:
            // $table->foreign('satuan_input')->references('idsatuan')->on('satuan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};