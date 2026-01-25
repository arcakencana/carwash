<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
            ->constrained('transaksi')
            ->cascadeOnDelete();

            $table->foreignId('master_barang_id')
            ->constrained('master_barang')
            ->cascadeOnDelete();

            $table->integer('qty');
            $table->integer('harga');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
