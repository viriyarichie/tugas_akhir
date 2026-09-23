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
            $table->id();
            $table->date('tgl');
            $table->foreignId('kasir_id')->constrained('user')->cascadeOnDelete();
            $table->enum('jenis', ['dine_in', 'takeaway']);
            $table->decimal('total_nota', 12, 2)->default(0);
            $table->decimal('service_charge', 12, 2)->default(0); // TODO: Konfirmasi dengan dosen
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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