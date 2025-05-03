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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('no_kontak');
            $table->text('url_dokumen');
            $table->text('kategori');
            $table->text('client');
            $table->enum('status', ['Mulai','Barang', 'BA', 'IH', 'Selesai'])->default('Mulai');
            $table->decimal('total', 18, 2);
            $table->date('deadline')->nullable();
            $table->date('tanggal_tagihan')->nullable();
            $table->foreignId('ditangani')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('riwayat_status_pekerjaan', function (Blueprint $table) {
            $table->id();
            // Ganti 'jobs' -> 'pekerjaan'
            $table->foreignId('job_id')->constrained('pekerjaan')->onDelete('cascade');
            $table->enum('status', ['Mulai','Barang', 'BA', 'IH', 'Selesai']);
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            // Ganti 'jobs' -> 'pekerjaan'
            $table->foreignId('job_id')->nullable()->constrained('pekerjaan')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('riwayat_status_pekerjaan');
        Schema::dropIfExists('pekerjaan');
    }
};
