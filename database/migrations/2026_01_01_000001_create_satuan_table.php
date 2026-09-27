<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('satuan', function (Blueprint $table) {
            $table->string('idsatuan', 3)->primary();
            $table->string('satuan', 45);
        });
    }
    public function down(): void { Schema::dropIfExists('satuan'); }
};