<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transaksi() : BelongsTo 
    {
        return $this->belongsTo(Transaksi::class); 
    }

    public function variant() : BelongsTo 
    {
        return $this->belongsTo(Variant::class);
    }
   
}
