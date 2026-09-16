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
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id('id_bahan');
            $table->string('nama_bahan', 100);
            $table->decimal('total_stok', 14, 3);
            $table->string('idsatuan', 3);
            $table->integer('stok_onorder_customer')->default(0);
            $table->integer('stok_onorder_supplier')->default(0);
            $table->enum('kategori', ['utama', 'tambahan', 'kemasan']);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idsatuan')->references('idsatuan')->on('satuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};