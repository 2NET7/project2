<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('kategori', ['Edukasi', 'Penyuluhan'])->after('judul');
            $table->enum('status', ['Draft', 'Published'])->default('Draft')->after('kategori');
            $table->date('tanggal')->after('status');
            $table->text('deskripsi')->after('tanggal');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'status', 'tanggal', 'deskripsi']);
        });
    }
};
