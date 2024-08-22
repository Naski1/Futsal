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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->integer('id_pemesanan')->autoIncrement()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('kode_pemesanan', 20);
            $table->date('tgl_pemesanan')->nullable();
            $table->integer('total_durasi')->unsigned()->nullable();
            $table->integer('total_biaya')->unsigned()->nullable();
            $table->integer('sisa_biaya')->unsigned()->nullable();
            $table->enum('status_bayar', ['belum', 'dp', 'selesai'])->nullable();
            $table->enum('status', ['booked', 'done', 'cancel'])->nullable();
            $table->timestamps();
        });

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
