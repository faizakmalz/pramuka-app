<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tkks', function (Blueprint $table) {
            $table->unsignedBigInteger('nomor_anggota')->after('id');
            $table->string('golongan_sekarang')->after('nomor_anggota');
            $table->string('nama_tkk')->after('golongan_sekarang');
            $table->string('tingkat')->nullable()->after('nama_tkk');
            $table->string('nama_penguji')->after('tingkat');
            $table->boolean('penguji_is_pembina')->default(false)->after('nama_penguji');
            $table->string('nomor_sertifikat')->unique()->nullable()->after('penguji_is_pembina');
            $table->date('tanggal_penetapan')->after('nomor_sertifikat');
            $table->string('tempat_penetapan')->after('tanggal_penetapan');
            $table->text('catatan')->nullable()->after('tempat_penetapan');

            $table->foreign('nomor_anggota')
                ->references('nomor_anggota')
                ->on('anggotas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tkks', function (Blueprint $table) {
            $table->dropForeign(['nomor_anggota']);
            $table->dropColumn([
                'nomor_anggota', 'golongan_sekarang', 'nama_tkk',
                'tingkat', 'nama_penguji', 'penguji_is_pembina',
                'nomor_sertifikat', 'tanggal_penetapan', 'tempat_penetapan', 'catatan'
            ]);
        });
    }
};
