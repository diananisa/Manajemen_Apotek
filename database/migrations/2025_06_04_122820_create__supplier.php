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
            $table->string('Id_supplier')->unique();
            $table->string('Nama_Supplier');
            $table->string('Kontak');
            $table->string('Alamat');
            $table->string('Jenis_Barang_Obat');
            $table->string('Nama_PIC');
            $table->string('Status');
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
