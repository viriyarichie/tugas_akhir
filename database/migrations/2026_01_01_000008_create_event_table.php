<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('event', function (Blueprint $table) {
            $table->id('idevent');
            $table->string('nama_event', 45);
            $table->string('jenis_event', 45);
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->string('keterangan', 255)->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('event'); }
};