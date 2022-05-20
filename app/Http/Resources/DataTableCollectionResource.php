<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataTableCollectionResource extends ResourceCollection
{
    public $columns;

    public function __construct($resource, $columns = [])
    {
        $this->columns = $columns;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'payload' => $request->all(),
            'columns' => $this->columns
        ];
    }
}
