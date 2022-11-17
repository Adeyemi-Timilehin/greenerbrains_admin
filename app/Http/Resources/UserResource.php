<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // var_dump($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'verified' => $this->verified,
            'type' => $this->type,
            'subscribed_subjects' => $this->subscribed_subjects ? $this->subscribed_subjects : [],
            'notebooks' => $this->notebooks ? $this->notebooks : [],
            'interests' => $this->interests ? $this->interests : [],
            'roles' => $this->roles ? $this->mapToArray($this->roles) : []
        ];
    }

    
    // converts roles array of object to flat arrays
    private function mapToArray($array = [], $key = 'name'){
        // safely return empty array to avoid breakage
        if(!isset($key) || gettype($array) !== 'array') return [];

        // logic to map key values
        $result = [];
        if($key !== ''){
            foreach ($array as $key => $item) {
                array_push($result, $item[$key]);
            }
            return $result;
        }
        return $result;
    }
}
