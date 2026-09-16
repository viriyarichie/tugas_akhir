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
        Schema::create('safety_stock_rop', function (Blueprint $table) {
            $table->id('id_ss');
            $table->unsignedBigInteger('id_bahan');
            $table->unsignedBigInteger('id_kebutuhan');
            $table->decimal('dmax', 14, 3);
            $table->decimal('dprediksi', 14, 3);
            $table->integer('lead_time');
            $table->decimal('safety_stock', 14, 3);
            $table->decimal('rop', 14, 3);

            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->onDelete('cascade');
            $table->foreign('id_kebutuhan')->references('id_kebutuhan')->on('kebutuhan_bahan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_stock_rop');
    }
};