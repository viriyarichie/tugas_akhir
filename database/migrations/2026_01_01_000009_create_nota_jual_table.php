<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('nota_jual', function (Blueprint $table) {
            $table->id('id_nota_jual');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('user')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('jenis', ['dine-in', 'takeaway', 'online']);
            $table->decimal('service_charge', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('event_idevent')->nullable();
            $table->foreign('event_idevent')->references('idevent')->on('event')->nullOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('nota_jual'); }
};