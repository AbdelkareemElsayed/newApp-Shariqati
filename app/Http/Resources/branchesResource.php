<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class branchesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

          $lang = ($request->header('Accept-Language') == "en")?"en":"ar";

          $name = "name_".$lang;

        return [
            'id'         => $this->id,
            'name'       => $this->$name,
            'email'      => $this->email
        ];
    }
}
