<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePraPenelitiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pra_penelitians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->foreignId('mou_id')
                ->constrained('mous')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->enum('jenis_penelitian', ['Data Awal', 'Uji Validitas', 'Penelitian']);
            $table->string('prodi'); 
            $table->date('tanggal_mulai');
            $table->date('tanggal_rencana_skripsi'); 
            $table->string('file_kerangka');
            $table->string('file_surat_pengantar');
            $table->string('dosen1_nama');
            $table->string('dosen1_hp');
            $table->string('dosen2_nama');
            $table->string('dosen2_hp');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
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
        Schema::dropIfExists('pra_penelitians');
    }
}
