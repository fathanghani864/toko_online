<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'nama_pemesan',
        'alamat',
        'jumlah',
        'kurir',
        'metode_pembayaran',
        'total_harga',
        'status',
    ];

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
