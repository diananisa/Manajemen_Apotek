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
            $table->string('Kode_Transaksi')->unique();
            $table->dateTime('Tanggal_Transaksi');
            $table->longText('Nama_Obat');
            $table->integer('Jumlah');
            $table->decimal("Harga_Satuan");
            $table->decimal('Total_Harga');
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
