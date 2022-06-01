<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Nomination extends Model
{
    use HasFactory;

    protected $table = 'nominations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    private static $nominationStatusLabelValueArray = [1 => 'Активен', 0 => 'Неактивен'];
    public static function getNominationStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$nominationStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getNominationStatusLabel(string $status): string
    {
        if ( isset(self::$nominationStatusLabelValueArray[$status])) {
            return self::$nominationStatusLabelValueArray[$status];
        }

        return '';
    }

    public function scopeGetById($query, $id = null)
    {
        if ( empty($id) ) {
            return $query;
        }

        return $query->where(with(new Nomination)->getTable() . '.id', $id);
    }


    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new Nomination)->getTable().'.active', $active);
    }



    public function scopeGetByTitle($query, $title = null)
    {
        if (empty($title)) {
            return $query;
        }

        return $query->where(with(new Nomination)->getTable() . '.title', 'like', '%' . $title . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($nomination) {
        });

    }


    public function photoNominations()
    {
        return $this->hasMany('App\Models\PhotoNomination');
    }



    public static function getNominationValidationRulesArray(  $nomination_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'title'       => [
                'required',
                'string',
                'max:50',
                Rule::unique(with(new Nomination)->getTable())->ignore($nomination_id),
            ],
            'slug'       => [
//                'required',
                'string',
                'max:55',
//                Rule::unique(with(new Nomination)->getTable())->ignore($nomination_id),
            ],
            'ordering'  => 'required|integer',
            'color'  => 'required|string|max:7',
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
