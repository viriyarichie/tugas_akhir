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
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id('id_stock_opname');
            $table->unsignedBigInteger('id_bahan');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal_cek');
            $table->decimal('stok_sistem', 14, 3);
            $table->decimal('stok_real', 14, 3);
            $table->string('keterangan', 255)->nullable();

            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname');
    }
};