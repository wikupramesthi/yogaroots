<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ClassScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $startTime = $this->start_time
            ? Carbon::parse($this->start_time)
            : null;

        $endTime = $this->end_time
            ? Carbon::parse($this->end_time)
            : null;

        return [

            'uuid' => $this->uuid,
            'day' => $this->day,
            'start_time' => $startTime
                ? $startTime->format('H:i')
                : null,

            'end_time' => $endTime
                ? $endTime->format('H:i')
                : null,

            'duration' => ($startTime && $endTime)
                ? $startTime->diffInMinutes($endTime)
                : null,

            'capacity' => $this->capacity,
            'status' => $this->status,

            'class' => [
                'uuid' => $this->class?->uuid,
                'name' => $this->class?->name,
                'slug' => $this->class?->slug,
                'level' => $this->class?->level,
                'description' => $this->class?->description,
                'image' => $this->class?->image
                    ? asset('storage/' . $this->class->image)
                    : null,
            ],

            'instructor' => [
                'uuid' => $this->class?->instructor?->uuid,
                'name' => $this->class?->instructor?->name,
                'avatar' => $this->class?->instructor?->avatar
                    ? asset('storage/' . $this->class->instructor->avatar)
                    : null,
            ],


            'studio' => [
                'uuid' => $this->studio?->uuid,
                'name' => $this->studio?->name,
                'address' => $this->studio?->address,
            ],

        ];
    }
}