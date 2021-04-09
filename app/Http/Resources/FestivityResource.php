<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FestivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'place' => $this->place,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
