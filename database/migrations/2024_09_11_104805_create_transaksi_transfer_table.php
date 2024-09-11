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
        Schema::create('transaksi_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bank_pengirim_id')->constrained('banks');
            $table->foreignId('bank_tujuan_id')->constrained('banks');
            $table->string('kode_unik', 3);
            $table->integer('jumlah_transfer');
            $table->integer('total_transfer');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_transfer');
    }
};
