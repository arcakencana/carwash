<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('no_polisi');
            $table->string('no_wa')->default('0');
            $table->date('tanggal');
            $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();
            $table->integer('total_harga')->default(0);
            $table->enum('status', ['belum', 'sudah'])->default('belum');
            $table->enum('jenis_bayar', ['cash', 'qris', 'debit']);
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
