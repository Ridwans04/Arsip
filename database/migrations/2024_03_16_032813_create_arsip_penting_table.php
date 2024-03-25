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
        Schema::create('arsip_penting', function (Blueprint $table) {
            $table->id();
            $table->string('institusi');
            $table->string('kode_arsip');
            $table->date('tanggal_arsip');
            $table->string('masa_penyimpanan');
            $table->string('klasifikasi_surat');
            $table->string('keterangan')->nullable();
            $table->foreignId('surat_id')->nullable();
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
        Schema::dropIfExists('arsip_penting');
    }
};
