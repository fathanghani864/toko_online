<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika ingin menggunakan factory
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Import Model User untuk relasi

class Produk extends Model // Pastikan nama class menggunakan huruf awal kapital: Produk
{
    use HasFactory;
    
    // Properti $fillable Wajib digunakan untuk Mass Assignment.
    // Ini harus mencakup SEMUA kolom yang diizinkan diisi melalui Produk::create().
    protected $fillable = [
        'user_id',       // PENTING: Controller mengisi kolom ini
        'nama',   // PENTING: Sesuaikan dengan nama input di create.blade.php
        'harga',
        'stok',
        'status',
        'deskripsi',
        'gambar',
    ];

    /**
     * Definisikan relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
