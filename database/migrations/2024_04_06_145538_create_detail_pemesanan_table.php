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
        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->integer('id_detail_pemesanan')->autoIncrement()->unsigned();
            $table->integer('pemesanan_id')->unsigned();
            $table->integer('jadwal_id')->unsigned();
            $table->integer('durasi')->unsigned()->nullable();
            $table->integer('biaya')->unsigned()->nullable();
            $table->enum('status', ['booked', 'done', 'cancel'])->nullable();
            $table->timestamps();
        });


        Schema::table('detail_pemesanan', function (Blueprint $table) {
            $table->foreign('pemesanan_id')->references('id_pemesanan')->on('pemesanan');
            $table->foreign('jadwal_id')->references('id_jadwal')->on('jadwal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan');
    }
};
