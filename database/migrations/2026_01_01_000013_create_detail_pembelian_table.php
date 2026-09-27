<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');
            $table->unsignedBigInteger('id_nota_beli');
            $table->foreign('id_nota_beli')->references('id_nota_beli')->on('nota_beli')->cascadeOnDelete();
            $table->unsignedBigInteger('id_bahan');
            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->cascadeOnDelete();
            $table->decimal('jumlah_pesan', 14, 3);
            $table->decimal('harga_total', 14, 3);
        });
    }
    public function down(): void { Schema::dropIfExists('detail_pembelian'); }
};