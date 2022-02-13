<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResources extends JsonResource
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
        //     'products_id'        => $this->products_id,
        //     'pd_name'            => $this->pd_name,
        //     'pd_category'        => $this->pd_category,
        //     'pd_price'           => $this->pd_price,
        //     'pd_stack'           => $this->pd_stack,
        //     'pd_state'           => $this->pd_state,
        //     'pd_description'     => $this->pd_description,
        // ];
    }
}
