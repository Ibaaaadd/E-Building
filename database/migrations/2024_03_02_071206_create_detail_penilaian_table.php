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
        Schema::create('detail_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_detail');
            $table->unsignedBigInteger('id_indikator');
            $table->unsignedBigInteger('id_surveyor')->nullable();
            $table->integer('nilai_indikator');
            $table->string('gambar_sebelum');
            $table->integer('nilai_survey')->nullable();
            $table->string('gambar_survey')->nullable();
            $table->integer('nilai_sesudah')->nullable();
            $table->string('gambar_sesudah')->nullable();
            $table->foreign('id_detail')->references('id')->on('detail')->onDelete('cascade');
            $table->foreign('id_indikator')->references('id')->on('indikator')->onDelete('cascade');
            $table->foreign('id_surveyor')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penilaian');
    }
};
