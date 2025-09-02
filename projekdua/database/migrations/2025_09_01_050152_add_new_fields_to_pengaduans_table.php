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
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->integer('korban_jiwa')->nullable()->after('status');
            $table->integer('kerusakan_infrastruktur')->nullable()->after('korban_jiwa');
            $table->integer('kerusakan_material')->nullable()->after('kerusakan_infrastruktur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['korban_jiwa', 'kerusakan_infrastruktur', 'kerusakan_material']);
        });
    }
};
