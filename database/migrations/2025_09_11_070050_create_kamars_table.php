<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->string('kd_kamar', 15)->primary();
            $table->char('kd_bangsal', 5)->nullable();
            $table->double('trf_kamar')->nullable();
            $table->enum('status', ['ISI', 'KOSONG', 'DIBERSIHKAN', 'DIBOOKING'])->nullable();
            $table->enum('kelas', ['Kelas 1','Kelas 2','Kelas 3','Kelas Utama','Kelas VIP','Kelas VVIP'])->nullable();
            $table->enum('statusdata', ['0','1'])->nullable();

            $table->index('kd_bangsal');
            $table->index('trf_kamar');
            $table->index('status');
            $table->index('kelas');
            $table->index('statusdata');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
