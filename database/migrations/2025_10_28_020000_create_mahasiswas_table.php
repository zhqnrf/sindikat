<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nm_mahasiswa');
            $table->foreignId('mou_id')
                ->nullable()
                ->constrained('mous') // Menyambung ke tabel 'mous'
                ->onDelete('set null');
            $table->string('prodi')->nullable();
            $table->string('no_hp', 20);
            $table->string('nm_ruangan')->nullable();
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->boolean('weekend_aktif')->default(false);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('share_token')->unique();
            $table->string('foto_path')->nullable();
            $table->timestamps();

            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
