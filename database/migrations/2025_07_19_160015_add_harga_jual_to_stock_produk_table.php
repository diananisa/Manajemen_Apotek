<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('_stock__produk', function (Blueprint $table) {
            if (Schema::hasColumn('_stock__produk', 'Harga_Satuan')) {
                $table->dropColumn('Harga_Satuan');
            }

            if (!Schema::hasColumn('_stock__produk', 'Harga_Jual')) {
                $table->decimal('Harga_Jual', 8, 2)->after('Tanggal_Kadaluarsa');
            }

            if (!Schema::hasColumn('_stock__produk', 'Jenis_Satuan')) {
                $table->string('Jenis_Satuan', 50)->after('Harga_Jual');
            }

            if (!Schema::hasColumn('_stock__produk', 'supplier_id')) {
                $table->unsignedBigInteger('supplier_id')->after('Jenis_Satuan');

                $table->foreign('supplier_id')
                    ->references('id')
                    ->on('_supplier')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('_stock__produk', function (Blueprint $table) {
            if (Schema::hasColumn('_stock__produk', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }

            if (Schema::hasColumn('_stock__produk', 'Jenis_Satuan')) {
                $table->dropColumn('Jenis_Satuan');
            }

            if (Schema::hasColumn('_stock__produk', 'Harga_Jual')) {
                $table->dropColumn('Harga_Jual');
            }
        });
    }
};
