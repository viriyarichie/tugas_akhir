<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_menu', 100);
            $table->decimal('harga_jual', 12, 2);
            $table->boolean('is_aktif')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('kategori_menu_idkategori_menu');
            $table->foreign('kategori_menu_idkategori_menu')->references('idkategori_menu')->on('kategori_menu')->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('menu'); }
};