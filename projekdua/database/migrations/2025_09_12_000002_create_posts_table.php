<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop post_media dulu jika ada, agar constraint tidak error
        if (Schema::hasTable('post_media')) {
            Schema::drop('post_media');
        }
        if (Schema::hasTable('posts')) {
            Schema::drop('posts');
        }
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
