<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CameraModel extends Model
{
    use HasFactory;

    protected $table = 'camera_models';
    protected $primaryKey = 'id';
    public $timestamps = false;


    private static $cameraModelStatusLabelValueArray = [1 => 'Активная', 0 => 'Неактивная'];
    public static function getCameraModelStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$cameraModelStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getCameraModelStatusLabel(string $status): string
    {
        if ( isset(self::$cameraModelStatusLabelValueArray[$status])) {
            return self::$cameraModelStatusLabelValueArray[$status];
        }

        return '';
    }


    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new CameraModel)->getTable().'.active', $active);
    }



    public function scopeGetByName($query, $name = null)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where(with(new CameraModel)->getTable() . '.name', 'like', '%' . $name . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($cameraModel) {
        });
    }


    public static function getCameraModelValidationRulesArray(  $camera_model_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'name'       => [
                'required',
                'string',
                'max:100',
                Rule::unique(with(new CameraModel)->getTable())->ignore($camera_model_id),
            ],
            'slug'       => [
//                'required',
                'string',
                'max:105',
//                Rule::unique(with(new CameraModel)->getTable())->ignore($camera_model_id),
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
