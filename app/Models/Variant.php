<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variant extends Model
{
    use HasFactory;

    protected $table = 'variant';
    protected $fillable = ['produk_id', 'warna', 'ukuran', 'stok', 'harga', "material"];


    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
