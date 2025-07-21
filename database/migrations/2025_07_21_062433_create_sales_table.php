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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // kasir
            $table->date('tanggal')->default(now());
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
