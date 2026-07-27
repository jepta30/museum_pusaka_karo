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
        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->string('telepon', 20)->nullable()->after('pekerjaan');
            $table->string('tujuan', 120)->nullable()->after('telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->dropColumn(['telepon', 'tujuan']);
        });
    }
};
