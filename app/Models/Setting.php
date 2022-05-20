<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ExtraFeaturesOfModel;

class Setting extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    /**
     * @param  string|array  $key_or_keys
     * @param  string|array  $value
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public static function val($key_or_keys, $value = 'not_set_1015316646')
    {
        if($value == 'not_set_1015316646'){
            if(is_array($key_or_keys)){
                $values = self::query()
                    ->whereIn('key', $key_or_keys)
                    ->get();
                $result = (object)[];
                foreach ($values as $value) {
                    $result->{$value->key} = $value->value;
                }
                return $result;
            }
            else{
                $value = self::query()
                    ->where('key',$key_or_keys)
                    ->first();
                return @$value->value;
            }
        }

        if(!is_array($key_or_keys)){
            Setting::query()->updateOrCreate(["key" => $key_or_keys], [
                "key" => $key_or_keys,
                "value" => $value,
            ]);
            return $value;
        }
        return false;
    }
}
