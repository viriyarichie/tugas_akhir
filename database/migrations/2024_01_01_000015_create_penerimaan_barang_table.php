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
            $table->id();
            $table->foreignId('detail_pembelian_id')->constrained('detail_pembelian')->cascadeOnDelete();
            $table->date('tgl_terima');
            $table->decimal('jumlah_diterima', 14, 3); // aktual dalam satuan dasar (trigger tambah stok)
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