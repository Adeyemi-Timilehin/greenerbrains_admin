<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContentsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $contents = [];
        for ($i=0; $i < count($this->collection); $i++) {
            if(isset($this->collection[$i])){
                array_push($contents, new ContentResource($this->collection[$i]));
            }

         }
        return $contents;
    }
}
