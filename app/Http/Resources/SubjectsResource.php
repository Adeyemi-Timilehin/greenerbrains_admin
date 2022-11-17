<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubjectsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $subjects = [];
        for ($i=0; $i < count($this->collection); $i++) {
            if(isset($this->collection[$i])){
                array_push($subjects, new SubjectResource($this->collection[$i]));
            }

         }
        return $subjects;
    }
}
