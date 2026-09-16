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
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->id('id_penerimaan');
            $table->unsignedBigInteger('id_detail_pembelian');
            $table->date('tanggal_terima');
            $table->decimal('jumlah_diterima', 14, 3);
            $table->string('keterangan', 255)->nullable();

            $table->foreign('id_detail_pembelian')->references('id_detail_pembelian')->on('detail_pembelian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barang');
    }
};