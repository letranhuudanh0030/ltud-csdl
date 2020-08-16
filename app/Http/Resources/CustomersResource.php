<?php

namespace App\Http\Resources;

use App\Event;
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

        if($this->event->first()){
            $id = $this->event->first()->id;
            $eventUser = Event::find($id)->user;
            if($eventUser){
                $user = $eventUser;
            }else{
                $user = null;
            }
        }else{
            $user = null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'company' => $this->company,
            'address' => $this->address,
            'status' => $this->status,
            'event' => $this->event->first(),
            'user' => $user
        ];
    }
}
