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
        Schema::create('ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->string('institusi');
            $table->date('tanggal_kirim');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal')->nullable();
            $table->string('nama_penerima');
            $table->enum('jenis',['Eksternal','Internal']);
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
        Schema::dropIfExists('ekspedisi');
    }
};
