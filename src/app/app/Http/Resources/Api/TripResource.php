<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'bus_number'        => $this->bus->bus_number,
            'name'              => $this->name,
            'departure_time'    => $this->departure_time,
            'from_station'      => $this->fromStation->name,
            'to_Station'        => $this->toStation->name,
        ];
    }
}
