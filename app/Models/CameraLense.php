<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CameraLense extends Model
{
    use HasFactory;

    protected $table = 'camera_lenses';
    protected $primaryKey = 'id';
    public $timestamps = false;


    private static $cameraLenseStatusLabelValueArray = [1 => 'Активная', 0 => 'Неактивная'];
    public static function getCameraLenseStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$cameraLenseStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getCameraLenseStatusLabel(string $status): string
    {
        if ( isset(self::$cameraLenseStatusLabelValueArray[$status])) {
            return self::$cameraLenseStatusLabelValueArray[$status];
        }

        return '';
    }


    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new CameraLense)->getTable().'.active', $active);
    }



    public function scopeGetByName($query, $name = null)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where(with(new CameraLense)->getTable() . '.name', 'like', '%' . $name . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($cameraLense) {
        });
    }


    public static function getCameraLenseValidationRulesArray(  $camera_lense_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'name'       => [
                'required',
                'string',
                'max:100',
                Rule::unique(with(new CameraLense)->getTable())->ignore($camera_lense_id),
            ],
            'slug'       => [
//                'required',
                'string',
                'max:105',
//                Rule::unique(with(new CameraLense)->getTable())->ignore($camera_lense_id),
            ],
            'active'  => 'nullable',
        ];

        foreach ($skipFieldsArray as $next_field) {
            if ( ! empty($validationRulesArray[$next_field])) {
                unset($validationRulesArray[$next_field]);
            }
        }

        return $validationRulesArray;
    }

}
