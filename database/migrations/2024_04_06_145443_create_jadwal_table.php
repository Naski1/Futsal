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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->integer('id_jadwal')->autoIncrement()->unsigned();
            $table->integer('lapangan_id')->unsigned();
            $table->integer('jam_id')->unsigned();
            $table->enum('status', ['y', 't'])->default('y')->nullable();
            $table->timestamps();
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->foreign('lapangan_id')->references('id_lapangan')->on('lapangan');
            $table->foreign('jam_id')->references('id_jam')->on('jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
