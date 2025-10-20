<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel users dan produks
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();

            $table->string('nama_pemesan');
            $table->string('alamat');
            $table->integer('jumlah');
            $table->enum('kurir', ['JNE', 'JNT', 'POS']);
            $table->enum('metode_pembayaran', ['COD', 'transfer']);
            $table->unsignedBigInteger('total_harga');
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
