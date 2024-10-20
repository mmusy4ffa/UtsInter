<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $fillable = ['judul', 'penulis', 'harga', 'stok', 'kategori_id'];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
