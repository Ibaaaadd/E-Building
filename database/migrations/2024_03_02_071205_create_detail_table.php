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
        Schema::create('detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_pelaporan');
            $table->foreign('id_pelaporan')->references('id')->on('pelaporan')->onDelete('cascade');
            $table->string('status');
            $table->string('bidang');
            $table->unsignedBigInteger('id_survey_at')->nullable();
            $table->foreign('id_survey_at')->references('id')->on('users')->onDelete('cascade');        
            $table->timestamp('survey_at')->nullable();
            $table->unsignedBigInteger('id_acc_at')->nullable();
            $table->foreign('id_acc_at')->references('id')->on('users')->onDelete('cascade');        
            $table->timestamp('acc_at')->nullable();
            $table->unsignedBigInteger('id_tolak_at')->nullable();
            $table->foreign('id_tolak_at')->references('id')->on('users')->onDelete('cascade');        
            $table->timestamp('tolak_at')->nullable();
            $table->unsignedBigInteger('id_selesai_at')->nullable();
            $table->foreign('id_selesai_at')->references('id')->on('users')->onDelete('cascade');        
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail');
    }
};
