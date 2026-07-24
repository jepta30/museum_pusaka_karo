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
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->unsignedBigInteger('warisan_budaya_id');
            $table->string('file_media');
            $table->enum('jenis_media', ['foto', 'video']);
            $table->string('keterangan', 255);
            $table->timestamps();

            $table->foreign('warisan_budaya_id')->references('warisan_budaya_id')->on('warisan_budayas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
