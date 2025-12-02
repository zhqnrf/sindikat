<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentasiTable extends Migration
{
    public function up()
    {
        Schema::create('presentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pra_penelitian_id')->constrained('pra_penelitians')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            
            // Data Jadwal dari Admin
            $table->date('tanggal_presentasi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('tempat');
            $table->text('keterangan_admin')->nullable();
            
            // File dari Mahasiswa
            $table->string('file_ppt')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            
            // Penilaian dari CI
            $table->enum('status_penilaian', ['pending', 'dinilai'])->default('pending');
            $table->enum('nilai', ['A', 'B', 'C', 'D'])->nullable();
            $table->json('hasil_penilaian')->nullable(); // Array of {judul, keterangan, nilai}
            $table->timestamp('dinilai_at')->nullable();
            
            // File Laporan (jika A/B)
            $table->string('file_laporan')->nullable();
            $table->timestamp('laporan_uploaded_at')->nullable();
            
            // Review Admin untuk Laporan
            $table->enum('status_laporan', ['pending', 'revisi', 'approved'])->default('pending');
            $table->text('keterangan_review')->nullable();
            
            // Status Akhir
            $table->enum('status_final', ['proses', 'selesai', 'ditolak'])->default('proses');
            $table->string('surat_selesai')->nullable();
            $table->string('sertifikat')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presentasi');
    }
}