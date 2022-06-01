<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Compilation extends Model
{
    use HasFactory;

    protected $table = 'compilations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    private static $compilationStatusLabelValueArray = [1 => 'Активен', 0 => 'Неактивен'];
    public static function getCompilationStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$compilationStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getCompilationStatusLabel(string $status): string
    {
        if ( isset(self::$compilationStatusLabelValueArray[$status])) {
            return self::$compilationStatusLabelValueArray[$status];
        }

        return '';
    }

    public function scopeGetById($query, $id = null)
    {
        if ( empty($id) ) {
            return $query;
        }

        return $query->where(with(new Compilation)->getTable() . '.id', $id);
    }



    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new Compilation)->getTable().'.active', $active);
    }



    public function scopeGetByTitle($query, $title = null)
    {
        if (empty($title)) {
            return $query;
        }

        return $query->where(with(new Compilation)->getTable() . '.title', 'like', '%' . $title . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($compilation) {
        });

    }


    public function photoCompilations()
    {
        return $this->hasMany('App\Models\PhotoCompilation');
    }



    public static function getCompilationValidationRulesArray(  $compilation_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'title'       => [
                'required',
                'string',
                'max:50',
                Rule::unique(with(new Compilation)->getTable())->ignore($compilation_id),
            ],
            'ordering'  => 'required|integer',
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

