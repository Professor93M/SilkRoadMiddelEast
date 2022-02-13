<?php

namespace App\Http\Resources;

use App\Models\Images;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return[
        //     'cat_id'        => $this->cat_id,
        //     'cat_name'      => $this->cat_name,
        //     'img_url'       => Images::
        //     // 'img_url'       => Images::morph
        // ];
    }
}
