<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bom', function (Blueprint $table) {
            $table->id('id_bom');
            $table->unsignedBigInteger('id_menu');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->cascadeOnDelete();
            $table->unsignedBigInteger('id_bahan');
            $table->foreign('id_bahan')->references('id_bahan')->on('bahan_baku')->cascadeOnDelete();
            $table->decimal('jumlah_bahan', 14, 3);
            $table->string('idsatuan', 3);
            $table->foreign('idsatuan')->references('idsatuan')->on('satuan')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bom');
    }
};
