<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,

            'avatar' => $this->avatar
                ? asset('storage/' . $this->avatar)
                : null,

            'pengalaman' => $this->pengalaman,
            'biografi' => $this->biografi,

            'specializations' => $this->specializations->map(function ($specialization) {
                return [
                    'uuid' => $specialization->uuid,
                    'name' => $specialization->name,
                    'slug' => $specialization->slug,
                ];
            }),
        ];
    }
}
