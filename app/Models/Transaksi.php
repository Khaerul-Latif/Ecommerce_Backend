<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'tanggal' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'user_id', 'total_harga', 'tanggal', 'kode_promo', 'status_pembayaran'
        , 'status_pengiriman', 'bukti_pembayaran', 'alamat_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function barangKeluar() : HasMany
    {
        return $this->hasMany(BarangKeluar::class, 'transaksi_id', 'id');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'alamat_id');
    }

}
