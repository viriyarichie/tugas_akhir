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
        Schema::create('nota_jual', function (Blueprint $table) {
            $table->id('id_nota_jual');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->enum('jenis', ['dine-in', 'take-away', 'delivery']);
            $table->decimal('service_charge', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_jual');
    }
};