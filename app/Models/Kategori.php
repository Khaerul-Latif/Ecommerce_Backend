<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $fillable = ['nama', 'slug', 'display'];

    public function produk() : HasMany
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'id');
    }

}
