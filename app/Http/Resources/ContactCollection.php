<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($contacts){
                return [
                    'id'                => $contacts->id,
                    'first_name'        => $contacts->first_name,
                    'last_name'         => $contacts->last_name,
                    'email'             => $contacts->email,
                    'contact_number'    => $contacts->contact_number,
                    'created_at'        => $contacts->created_at->diffForHumans(),
                    'slug'              => $contacts->slug,
                ];
            })
        ];
    }
}
