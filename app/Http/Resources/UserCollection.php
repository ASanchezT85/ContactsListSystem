<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($users){
                return [
                    'id'            => $users->id,
                    'name'          => $users->name,
                    'created_at'    => $users->created_at->diffForHumans(),
                    'contacts'      => $users->contacts->count(),
                ];
            })
        ];
    }
}
