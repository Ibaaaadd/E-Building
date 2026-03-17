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
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lama')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_dinas');
            $table->unsignedBigInteger('id_sektor')->nullable();
            $table->unsignedBigInteger('id_jenis')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();

            $table->string('kode_gedung')->default('');
            $table->string('nama_gedung');
            $table->text('alamat_gedung')->nullable();
            $table->string('foto_gedung');
            $table->integer('luas_gedung');
            $table->integer('luas_tanah');
            $table->double('longitude');
            $table->double('latitude');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_dinas')->references('id')->on('dinas')->onDelete('cascade');
            $table->foreign('id_sektor')->references('id')->on('sektor')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id')->on('jenis')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedung');
    }
};
