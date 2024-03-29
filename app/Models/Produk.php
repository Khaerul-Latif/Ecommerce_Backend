<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['nama', 'deskripsi', 'gambar', "slug", "kategori_id", "display", "dimension", "berat", "material"];

    public function kategori() : BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function gambarProduk() : HasMany
    {
        return $this->hasMany(GambarProduk::class, 'produk_id', 'id');
    }

    public function keranjang() 
    {
        return $this->hasMany(Keranjang::class);
    }

    public function variant() : HasMany
    {
        return $this->hasMany(Variant::class, 'produk_id', 'id');
    }

    public function gambar() : HasMany
    {
        return $this->hasMany(GambarProduk::class, 'produk_id', 'id');
    }

    public function review() : HasMany
    {
        return $this->hasMany(Review::class, 'produk_id', 'id');
    }
}
