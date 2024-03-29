<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $review = Review::where('produk_id', $this->id)->get();
        return [
            'id' => $this->id,
            'kategori_id' => $this->kategori_id,
            'kategori' => $this->kategori->nama,
            'nama' => $this->nama,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'dimension' => $this->dimension,
            'berat' => $this->berat,
            'material' => $this->material,
            'display' => $this->display,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            "variant" => $this->variant,
            "gambar" => $this->gambar,
            "review" => ReviewForProductResource::collection($review),
        ];
    }
}
