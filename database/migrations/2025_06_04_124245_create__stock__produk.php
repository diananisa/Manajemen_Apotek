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
            $table->string('gambar')->nullable();
            $table->char('Id_Obat');
            $table->string('Nama_Obat');
            $table->string('Tanggal_Kadaluarsa');
            $table->string('Jumlah');
            $table->string('Total_Harga');
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
