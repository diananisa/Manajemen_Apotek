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
        Schema::create('_stock__produk', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Product', 100);
            $table->date('Tanggal_kadaluarsa');
            $table->integer('Stock');
            $table->float('Harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_stock__produk');
    }
};
