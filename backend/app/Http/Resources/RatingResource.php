<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
         'Id' => $this->id,
         'Meno' => $this->name,
         'Hodnotenie' => $this->rate,
         'Koment' => $this->comment,
       ];
        // return [
      //    'id' => $this->id,
      //    'name' => $this->name,
      //    'rate' => $this->rate,
      //    'comment' => $this->comment,
      //  ];
        // return parent::toArray($request);
    }
}
