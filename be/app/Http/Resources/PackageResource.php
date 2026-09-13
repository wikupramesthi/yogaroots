<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'uuid' => $this->uuid,

            'name' => $this->name,

            'slug' => $this->slug,

            'description' => $this->description,

            'is_popular' => (bool) $this->is_popular,

            'options' => $this->options->map(function ($option) {

                $finalPrice = (
                    $option->discount_price !== null &&
                    $option->discount_price < $option->price
                )
                    ? $option->discount_price
                    : $option->price;

                return [

                    'uuid' => $option->uuid,

                    'name' => $option->name,

                    'quota' => $option->quota,

                    'price' => $option->price,

                    'discount_price' => $option->discount_price,

                    'final_price' => $finalPrice,

                    'duration' => $option->duration,

                    'duration_unit' => $option->duration_unit,

                    'sort_order' => $option->sort_order,

                ];
            }),

            'features' => $this->features->map(function ($feature) {

                return [

                    'uuid' => $feature->uuid,

                    'feature' => $feature->feature,

                    'sort_order' => $feature->sort_order,

                ];
            }),

        ];
    }
}
