<?php

namespace App\Http\Resources;

use App\Event;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this['name'],
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'summary' => $this->summary,
            'result' => $this->result,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'email' => $this->customer->email,
                'company' => $this->customer->company,
                'address' => $this->customer->address,
                'status' => $this->customer->status,
                'created_at' => $this->customer->created_at,
                'updated_at' => $this->customer->updated_at,

            ],
            'users' => $this->user 
        ];
    }
}
