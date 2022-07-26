<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleBranchesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if(App()->getLocale() == "en"){
            $name = "name_en";
            $location = "name";
        }else{
            $name = "name_ar";
            $location = "name_ar";
        }


        return [
            "id"          => $this->id,
            "name"        => $this->$name,
            "email"       => $this->email,
            "phone"       => $this->phone,
            "facebook"    => $this->facebook,
            "whatsapp"    => $this->whatsapp,
            "instagram"   => $this->instagram,
            "linkedin"    => $this->linkedin,
            "twitter"     => $this->twitter,
            "tiktok"      => $this->tiktok,
            "snapchat"    => $this->snapchat,
            "location"    => $this->location,
            'country'     => $this->GetCountry->$location,
            'state'       => $this->Getstate->$location,
            'city'        => $this->GetCity->$location,
            "streetName"  => $this->streetName,
            "buildNumber" => $this->buildNumber,
            "commomPlaces" => $this->commomPlaces,
            "address_additional" => $this->address_additional,
        ];
    }
}
