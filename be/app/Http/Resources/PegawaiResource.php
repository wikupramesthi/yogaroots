<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class PegawaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'uuid'           => $this->uuid,
            'name'           => $this->name,
            'email'          => $this->email,
            'no_hp'          => $this->no_hp,
            // 'nik'            => $this->nik,
            'nuptk'          => $this->nuptk,
            'jabatan'        => $this->jabatan,
            'kepegawaian'   => match ($this->kepegawaian) {
                'asn'      => 'ASN',
                'honorer'  => 'Honorer',
                'magang'   => 'Magang',
                'lainnya'  => 'Lainnya',
                default    => null,
            },
            'jenis_kelamin' => match ($this->jenis_kelamin) {
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
                default => null,
            },
            'agama'          => $this->agama,
            'alamat'         => $this->alamat,
            'facebook'       => $this->facebook,
            'instagram'      => $this->instagram,
            'twitter'        => $this->twitter,
            'tiktok'         => $this->tiktok,
            'youtube'        => $this->youtube,
            'biografi'       => $this->biografi,
            'avatar' => $this->avatar && Storage::disk('public')->exists($this->avatar)
                ? asset('storage/' . $this->avatar)
                : url('images/default-avatar.png'),

            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }
}
