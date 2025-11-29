<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsultasiTable extends Migration
{
    public function up()
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pra_penelitian_id')->constrained('pra_penelitians')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_konsul');
            $table->text('hasil_konsul');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konsultasi');
    }
}