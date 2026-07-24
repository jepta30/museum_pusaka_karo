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
        Schema::create('warisan_budayas', function (Blueprint $table) {
            $table->id('warisan_budaya_id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('judul', 150);
            $table->string('lokasi', 150);
            $table->text('deskripsi');
            $table->longText('sejarah');
            $table->string('gambar', 225);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->integer('jumlah_dilihat')->default(0);
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warisan_budayas');
    }
};
