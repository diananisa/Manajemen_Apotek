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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string('Username', 255);
            $table->date('tanggal');
            $table->time('jam')->nullable();
            $table->timestamps();

            $table->foreign('Username')->references('Username')->on('logins')->onDelete('cascade'); //user hanya presensi sekali per hari
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
