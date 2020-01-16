<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Outlet extends JsonResource
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
            'id' => $this->loc_id,
            'name' => $this->name,
            'address_city' => $this->address_city,
            'address_street' => $this->address_street,
            'map_popup_content' => $this->map_popup_content,
            'map_admin_popup_content' => $this->map_admin_popup_content,
        ];
    }
}
