<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $timestamps = false;


    private static $tagStatusLabelValueArray = [1 => 'Активен', 0 => 'Неактивен'];
    public static function getTagStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$tagStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getTagStatusLabel(string $status): string
    {
        if ( isset(self::$tagStatusLabelValueArray[$status])) {
            return self::$tagStatusLabelValueArray[$status];
        }

        return '';
    }


    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new Tag)->getTable().'.active', $active);
    }



    public function scopeGetByTitle($query, $title = null)
    {
        if (empty($title)) {
            return $query;
        }

        return $query->where(with(new Tag)->getTable() . '.title', 'like', '%' . $title . '%');
    }


    public function photoTags()
    {
        return $this->hasMany('App\Models\PhotoTag');
    }

    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($tag) {
        });
    }


    public static function getTagValidationRulesArray(  $tag_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'title'       => [
                'required',
                'string',
                'max:50',
                Rule::unique(with(new Tag)->getTable())->ignore($tag_id),
            ],
            'slug'       => [
//                'required',
                'string',
                'max:55',
//                Rule::unique(with(new tag)->getTable())->ignore($tag_id),
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
