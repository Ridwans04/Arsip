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
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('institusi');
            $table->string('nomor_dokumen');
            $table->string('nama_dokumen');
            $table->string('kode_arsip');
            $table->date('tanggal_arsip');
            $table->string('masa');
            $table->foreignId('surat_id');
            $table->foreignId('disposisi_id')->nullable();
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
        Schema::dropIfExists('arsip');
    }
};
