<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('_stock__produk', function (Blueprint $table) {
            $table->decimal('Harga_Jual', 8, 2)->after('Tanggal_Kadaluarsa');
        });
    }

    public function down(): void
    {
        Schema::table('_stock__produk', function (Blueprint $table) {
            if (Schema::hasColumn('_stock__produk', 'Harga_Jual')) {
                $table->dropColumn('Harga_Jual');
            }
        });
    }
};
