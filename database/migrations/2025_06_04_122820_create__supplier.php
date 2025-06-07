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
        Schema::create('_supplier', function (Blueprint $table) {
            $table->id();
            $table->char('Id_supplier', 10);
            $table->string('Nama_Produck', 100);
            $table->date('Tanggal_Masuk');
            $table->date('Tanggal_Kadaluarsa');
            $table->integer('Jumlah');
            $table->float('Total_Harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_supplier');
    }
};
