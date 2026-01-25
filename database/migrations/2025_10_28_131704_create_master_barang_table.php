<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('harga_modal')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->enum('kategori', ['primary', 'secondary'])->default('primary');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_barang');
    }
};
