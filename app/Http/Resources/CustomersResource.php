<?php

namespace App\Http\Resources;

use App\Event;
use App\User;
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
            $eventUser = Event::find($id)->user->where("pivot.status", 1);
            $user = $eventUser;
        }else{
            $user = [];
        }

        $arrayData = [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'company' => $this->company,
            'address' => $this->address,
            'status' => $this->status,
            'event' => $this->event->first(),
            'user' => $user,
        ];

        if(request()->user()->role->level_role != 0){
            foreach ((array)$user as $users) {
                foreach ($users as  $user_item) {
                    if(request()->user()->id == $user_item->id){
                        return $arrayData;
                    }
                }
            }
        }else{
            return $arrayData;
        }
    }

    
}
