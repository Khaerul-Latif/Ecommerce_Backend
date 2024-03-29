<?php

namespace App\Http\Resources;

use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangKeluarResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $variant = Variant::find($this->variant_id);
        $produk = $variant->produk;
        return [
            "id" => $this->id,
            "transaksi_id" => $this->transaksi_id,
            "variant_id" => $this->variant_id,
            "jumlah" => $this->jumlah,
            "variant" => $variant,
            "produk" => $produk,
            
        ];
    }
}
