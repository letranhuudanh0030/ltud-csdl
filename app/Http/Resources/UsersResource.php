<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
                'level_role' => $this->role->level_role,
                'status' => $this->role->status
            ],
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
