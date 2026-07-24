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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id('kunjungan_id');
            $table->string('halaman', 255);
            $table->unsignedBigInteger('warisan_budaya_id')->nullable();
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('perangkat', 50);
            $table->string('kota', 100);
            $table->string('ip', 45);
            $table->timestamps();

            $table->foreign('warisan_budaya_id')->references('warisan_budaya_id')->on('warisan_budayas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
