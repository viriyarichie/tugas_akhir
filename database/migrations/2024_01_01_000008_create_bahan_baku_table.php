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
            $table->id();
            $table->string('nama', 100);
            $table->foreignId('satuan_dasar_id')->constrained('satuan')->cascadeOnDelete();
            $table->decimal('total_stok', 14, 3)->default(0);
            $table->enum('kategori', ['utama', 'pendukung']);
            // TODO: stok_onorder_customer & stok_onorder_supplier (Menunggu konfirmasi)
            $table->integer('stok_onorder_customer')->default(0);
            $table->integer('stok_onorder_supplier')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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