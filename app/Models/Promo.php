<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $casts = [
        "start_date" => "datetime:Y-m-d H:i:s",
        "end_date" => "datetime:Y-m-d H:i:s",
        "created-at" => "datetime:Y-m-d H:i:s",
        "updated-at" => "datetime:Y-m-d H:i:s",
    ];
    protected $fillable = ['kode', 'diskon', 'start_date', 'end_date'];
    protected $table = 'promo';
    use HasFactory;
}
