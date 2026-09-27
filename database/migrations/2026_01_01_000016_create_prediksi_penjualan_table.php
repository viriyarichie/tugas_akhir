<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('prediksi_penjualan', function (Blueprint $table) {
            $table->id('id_prediksi');
            $table->unsignedBigInteger('id_menu');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->cascadeOnDelete();
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->enum('metode', ['TES', 'Census II']);
            $table->decimal('hasil_prediksi', 12, 2);
            $table->decimal('mape', 6, 3);
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down(): void { Schema::dropIfExists('prediksi_penjualan'); }
};