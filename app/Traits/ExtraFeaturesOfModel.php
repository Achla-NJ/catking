<?php

namespace App\Traits;


use Illuminate\Support\Facades\Schema;

trait ExtraFeaturesOfModel
{
    public function createAll($data)
    {
        $now = now();
        $data = collect($data)->map(function($item) use ($now) {
            return array_merge($item,[
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        })->toArray();

        return $this->query()->insert($data);
    }

    public static function getSchemaColumns()
    {
        return Schema::getColumnListing((new self())->getTable());
    }

    public static function getSchema()
    {
        return (new self())->getTable();
    }
}
