<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $event = $this->event;
        if(!$event->first()['name']){
            $eventArr = [];
        } else {
            $eventArr = [
                'name' => $this->event->first()['name'],
                'time_start' => $this->event->first()['time_start'],
                'time_end' => $this->event->first()['time_end'],
                'summary' => $this->event->first()['summary'],
                'result' => $this->event->first()['result'],
                'status' => $this->event->first()['status']
            ];
        }

        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'company' => $this->company,
            'address' => $this->address,
            'status' => $this->status,
            'event' => $eventArr
        ];
    }
}
