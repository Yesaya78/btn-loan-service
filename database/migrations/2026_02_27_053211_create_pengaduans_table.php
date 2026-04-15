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
        Schema::create('pengaduans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID pelapor
    $table->string('judul');
    $table->text('isi_laporan');
    $table->string('foto')->nullable(); // Untuk menyimpan nama file foto bukti
    $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
