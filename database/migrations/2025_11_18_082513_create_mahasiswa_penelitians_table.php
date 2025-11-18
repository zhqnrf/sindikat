<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaPenelitiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_penelitians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pra_penelitian_id')
                ->constrained('pra_penelitians')
                ->onDelete('cascade'); // Jika penelitian dihapus, data mhs ikut hapus
            $table->string('nama');
            $table->string('no_telpon');
            $table->string('jenjang');
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
        Schema::dropIfExists('mahasiswa_penelitians');
    }
}
