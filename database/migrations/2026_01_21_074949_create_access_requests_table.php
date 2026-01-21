<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();

            // Data Pemohon
            $table->string('name');
            $table->string('email');
            $table->string('department')->nullable(); // Unit/Divisi
            $table->string('position')->nullable();   // Jabatan

            // Jenis Permintaan
            $table->enum('request_type', [
                'new_account',
                'reset_password',
                'access_grant',
                'other'
            ]);
            $table->text('reason'); // Alasan permintaan

            // Status Workflow
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // Catatan dari admin jika reject/approve
            $table->foreignId('processed_by')->nullable()->constrained('users'); // Siapa admin yang memproses

            $table->string('pdf_path')->nullable(); // Lokasi file PDF yang tergenerate

            $table->timestamps();
        });
    }
};
