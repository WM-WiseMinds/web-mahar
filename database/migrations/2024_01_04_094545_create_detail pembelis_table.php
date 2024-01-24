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
        Schema::create('detail pembeli', function (Blueprint $table) {
            // Ini adalah primary key yang akan menyimpan ID
            $table->id();
            // Ini adalah foreign key yang mengacu pada kolom 'user_id' pada tabel 'user' dengan penghapusan data 'cascade'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Ini adalah kolom untuk menyimpan alamat dengan panjang maksimal 255 karakter
            $table->string('alamat', 255);
            // Ini adalah kolom untuk menyimpan nomor WhatsApp dengan panjang maksimal 15 karakter
            $table->string('no_wa', 15);
            // Ini adalah kolom untuk menyimpan tanggal transaksi terakhir dalam format DateTime
            $table->dateTime('tanggal_transaksi_terakhir');
            // Ini adalah timestamp untuk createdAt dan updatedAt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpembelis');
    }
};
