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
        Schema::create('bom', function (Blueprint $table) {
            $table->id('id_bom');
            $table->unsignedBigInteger('id_menu');
            $table->unsignedBigInteger('id_bahan');
            $table->decimal('jumlah_bahan', 14, 3);
            $table->string('idsatuan', 3);

            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->onDelete('cascade');
            $table->foreign('idsatuan')->references('idsatuan')->on('satuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom');
    }
};