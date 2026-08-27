<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'              => $this->uuid,
            'judul'             => $this->judul,
            'deskripsi'         => $this->deskripsi,
            'link'              => $this->link ?? null,
            'icon'              => $this->icon
                                        ? asset('storage/' . ltrim($this->icon, '/'))
                                        : asset('images/default.png'),
            'kategori'          => $this->kategori_layanan,
            'color'             => $this->color,
            'status'            => $this->status,
        ];
    }
}
