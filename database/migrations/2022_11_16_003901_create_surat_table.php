<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('institusi');
            $table->string('nomor_surat');
            $table->string('nama_dokumen');
            $table->string('klasifikasi');
            $table->date('tanggal');
            $table->string('dari')->nullable();
            $table->string('tujuan_surat')->nullable();
            $table->enum('sifat', ['Penting', 'Biasa'])->nullable();
            $table->string('perihal')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('jenis_surat',['Masuk', 'Keluar']);
            $table->string('dokumen')->nullable();
            $table->foreignId('dokumen_id');
            $table->foreignId('disposisi_id')->nullable();
            $table->foreignId('arsip_id')->nullable();
            $table->foreignId('ekspedisi_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat');
    }
};
