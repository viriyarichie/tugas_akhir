<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_jual');
            $table->unsignedBigInteger('id_nota_jual');
            $table->foreign('id_nota_jual')->references('id_nota_jual')->on('nota_jual')->cascadeOnDelete();
            $table->unsignedBigInteger('id_menu');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->cascadeOnDelete();
            $table->integer('qty');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
        });
    }
    public function down(): void { Schema::dropIfExists('detail_penjualan'); }
};