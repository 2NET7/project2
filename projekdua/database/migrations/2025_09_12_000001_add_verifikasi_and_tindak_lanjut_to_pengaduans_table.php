<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->enum('verifikasi', ['diterima', 'ditolak'])->nullable()->after('bukti');
            $table->enum('tindak_lanjut_status', ['Menunggu', 'Proses', 'Selesai'])->nullable()->after('verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['verifikasi', 'tindak_lanjut_status']);
        });
    }
};
