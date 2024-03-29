<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "alamat_id" => $this->alamat_id,
            "total_harga" => $this->total_harga,
            "tanggal" => $this->tanggal,
            "kode_promo" => $this->kode_promo,
            "status_pembayaran" => $this->status_pembayaran,
            "status_pengiriman" => $this->status_pengiriman,
            "bukti_pembayaran" => $this->bukti_pembayaran,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "barang_keluar" => BarangKeluarResouce::collection($this->barangKeluar),

        ];
    }
}
