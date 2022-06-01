<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camera extends Model
{
    use HasFactory;

    protected $table = 'cameras';
    protected $primaryKey = 'id';
    public $timestamps = false;


    private static $cameraStatusLabelValueArray = [1 => 'Активная', 0 => 'Неактивная'];

    public static function getCameraStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$cameraStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getCameraStatusLabel(string $status): string
    {
        if (isset(self::$cameraStatusLabelValueArray[$status])) {
            return self::$cameraStatusLabelValueArray[$status];
        }

        return '';
    }


    public function scopeGetByActive($query, $active = null)
    {
        if ( ! isset($active) or strlen($active) == 0) {
            return $query;
        }

        return $query->where(with(new Camera)->getTable() . '.active', $active);
    }


    public function scopeGetByName($query, $name = null)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where(with(new Camera)->getTable() . '.name', 'like', '%' . $name . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($camera) {
        });
    }


    public static function getCameraValidationRulesArray(
        $camera_id = null,
        array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique(with(new Camera)->getTable())->ignore($camera_id),
            ],
            'slug' => [
                'required',
                'string',
                'max:105',
                Rule::unique(with(new Camera)->getTable())->ignore($camera_id),
            ],
            'active' => 'nullable',
        ];

        foreach ($skipFieldsArray as $next_field) {
            if ( ! empty($validationRulesArray[$next_field])) {
                unset($validationRulesArray[$next_field]);
            }
        }

        return $validationRulesArray;
    }

}
