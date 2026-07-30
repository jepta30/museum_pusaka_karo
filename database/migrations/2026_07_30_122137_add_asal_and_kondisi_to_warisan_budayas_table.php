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
        Schema::table('warisan_budayas', function (Blueprint $table) {
            $table->string('asal', 100)->nullable()->after('lokasi');
            $table->string('kondisi', 50)->nullable()->after('asal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warisan_budayas', function (Blueprint $table) {
            $table->dropColumn(['asal', 'kondisi']);
        });
    }
};
