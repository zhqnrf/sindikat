<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentAndCiFieldsToPengajuanTable extends Migration
{
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // File paths
            $table->string('surat_balasan')->nullable()->after('status');
            $table->string('invoice')->nullable()->after('surat_balasan');
            $table->string('bukti_pembayaran')->nullable()->after('invoice');
            
            // CI Information
            $table->string('ci_nama')->nullable()->after('bukti_pembayaran');
            $table->string('ci_no_hp')->nullable()->after('ci_nama');
            $table->string('ci_bidang')->nullable()->after('ci_no_hp');
            $table->string('ruangan')->nullable()->after('ci_bidang');
            
            // Status tambahan
            $table->enum('status_galasan', ['pending', 'sent'])->default('pending')->after('status');
            $table->enum('status_pembayaran', ['pending', 'uploaded', 'verified'])->default('pending')->after('status_galasan');
        });
    }

    public function down()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn([
                'surat_balasan',
                'invoice',
                'bukti_pembayaran',
                'ci_nama',
                'ci_no_hp',
                'ci_bidang',
                'ruangan',
                'status_galasan',
                'status_pembayaran'
            ]);
        });
    }
}