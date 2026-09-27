<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_nota_jual');
            $table->foreign('id_nota_jual')->references('id_nota_jual')->on('nota_jual')->cascadeOnDelete();
            $table->enum('metode_bayar', ['cash', 'qris', 'transfer', 'edc']);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->dateTime('tanggal_bayar');
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};