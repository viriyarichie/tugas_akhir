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
            $table->id();
            $table->date('tgl');
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->cascadeOnDelete(); // nullable in case beli di pasar
            $table->decimal('total_nota', 12, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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