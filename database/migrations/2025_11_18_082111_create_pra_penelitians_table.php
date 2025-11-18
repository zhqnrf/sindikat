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
            $table->string('judul');
            $table->foreignId('mou_id')
                ->constrained('mous')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // Jangan hapus MOU jika penelitian masih ada
            $table->enum('jenis_penelitian', ['Data Awal', 'Uji Validitas', 'Penelitian']);
            $table->date('tanggal_mulai');
            $table->enum('status', ['Aktif', 'Batal'])->default('Aktif');
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
