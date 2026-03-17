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
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_gedung');
            $table->unsignedBigInteger('id_dinas');
            $table->date('tanggal_laporan')->useCurrent();
            $table->text('deskripsi_laporan')->nullable();
            $table->string('surat');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_gedung')->references('id')->on('gedung')->onDelete('cascade');
            $table->foreign('id_dinas')->references('id')->on('dinas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporan');
    }
};
