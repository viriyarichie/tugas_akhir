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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_jual');
            $table->unsignedBigInteger('id_nota_jual');
            $table->unsignedBigInteger('id_menu');
            $table->integer('qty');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);

            $table->foreign('id_nota_jual')->references('id_nota_jual')->on('nota_jual')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};