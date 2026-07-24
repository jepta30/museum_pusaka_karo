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
        Schema::create('koleksis', function (Blueprint $table) {
            $table->string('nomor_koleksi', 20)->primary();
            $table->string('nama_koleksi', 50);
            $table->string('jenis_koleksi', 50);
            $table->string('nama_pemilik', 50);
            $table->string('cara_perolehan', 50);
            $table->string('tempat_perolehan', 50);
            $table->string('tanggal_masuk', 50);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksis');
    }
};
