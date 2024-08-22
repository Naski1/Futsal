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
        Schema::create('jam', function (Blueprint $table) {
            $table->integer('id_jam')->autoIncrement()->unsigned();
            $table->string('nama_jam', 100);
            $table->time('jam_awal');
            $table->time('jam_akhir');
            $table->integer('durasi')->unsigned()->nullable();
            $table->integer('biaya')->unsigned()->nullable();
            $table->enum('status', ['y', 't'])->default('y')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam');
    }
};
