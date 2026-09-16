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
        Schema::create('nota_beli', function (Blueprint $table) {
            $table->id('id_nota_beli');
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_beli');
    }
};