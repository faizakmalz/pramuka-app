<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gugus_depan')->default('Gugus Depan 11.021-11.022');
            $table->string('nomor_gugus_depan')->default('11.021-11.022');
            $table->text('alamat')->nullable();
            $table->json('pembina')->nullable(); // Array of pembina: [{nama, nip, is_ketua}]
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();
            $table->timestamps();
        });

        // Insert default data
        \DB::table('settings')->insert([
            'nama_gugus_depan' => 'Gugus Depan 11.021-11.022',
            'nomor_gugus_depan' => '11.021-11.022',
            'alamat' => 'Surabaya, Jawa Timur',
            'pembina' => json_encode([
                ['nama' => 'Drs. Bambang Sudirman, M.Pd.', 'nip' => '196512151990031004', 'is_ketua' => true],
            ]),
            'nama_kepala_sekolah' => 'Dr. Siti Nurhaliza, S.Pd., M.Pd.',
            'nip_kepala_sekolah' => '197803122005012001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};