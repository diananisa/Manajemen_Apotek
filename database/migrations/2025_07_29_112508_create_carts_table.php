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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_Obat');
            $table->string('Kode_Transaksi');
            $table->dateTime('Tanggal_Transaksi');
            $table->string('Nama_Obat');
            $table->integer('Jumlah');
            $table->decimal('Harga_Satuan', 10, 2);
            $table->decimal('Total_Harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
