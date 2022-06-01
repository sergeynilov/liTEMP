<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Photo extends Model  implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'photos';
    protected $primaryKey = 'id';
    public $timestamps = false;


    private static $photoStatusLabelValueArray = [1 => 'Активная', 0 => 'Неактивная'];

    public static function getPhotoStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$photoStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getPhotoStatusLabel(string $status): string
    {
        if (isset(self::$photoStatusLabelValueArray[$status])) {
            return self::$photoStatusLabelValueArray[$status];
        }

        return '';
    }

    public function scopeGetById($query, $id = null)
    {
        if ( empty($id) ) {
            return $query;
        }

        return $query->where(with(new Photo)->getTable() . '.id', $id);
    }

    public function scopeGetByActive($query, $active = null)
    {
        if ( ! isset($active) or strlen($active) == 0) {
            return $query;
        }

        return $query->where(with(new Photo)->getTable() . '.active', $active);
    }

    public function scopeGetByShownOnHomepage($query, $shown_on_homepage = null)
    {
        if ( ! isset($shown_on_homepage) or strlen($shown_on_homepage) == 0) {
            return $query;
        }

        return $query->where(with(new Photo)->getTable() . '.shown_on_homepage', $shown_on_homepage);
    }

    public function scopeGetByOwnerId($query, $owner_id = null)
    {
        if ( ! isset($owner_id) or strlen($owner_id) == 0) {
            return $query;
        }

        return $query->where(with(new Photo)->getTable() . '.owner_id', $owner_id);
    }


    public function scopeGetByName($query, $name = null)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where(with(new Photo)->getTable() . '.name', 'like', '%' . $name . '%');
    }


    public function scopeGetByPublishedAt($query, $filter_published_at= null, string $sign= null)
    {
        if (!empty($filter_published_at)) {
            if (!empty($sign)) {
                $query->whereRaw( with(new Photo)->getTable().'.published_at ' . $sign . "'".$filter_published_at."' " );
            } else {
                $query->where(with(new Photo)->getTable().'.published_at', $filter_published_at);
            }
        }
        return $query;
    }

    public function scopeGetByCreatedAt($query, $filter_created_at= null, string $sign= null)
    {
        if (!empty($filter_created_at)) {
            if (!empty($sign)) {
                $query->whereRaw( with(new Photo)->getTable().'.created_at ' . $sign . "'".$filter_created_at."' " );
            } else {
                $query->where(with(new Photo)->getTable().'.created_at', $filter_created_at);
            }
        }
        return $query;
    }

    public function scopeGetByTags($query, $tags = null)
    {
        if ( empty($tags) or count($tags) == 0) {
            return $query;
        }
        $query->leftJoin('photo_tags', 'photo_tags.photo_id', '=', 'photos.id');
        $query->whereIn(with(new PhotoTag)->getTable() . '.tag_id', $tags);
    }

    public function scopeGetByPhotoNominationsCount($query, $nominations_count = null)
    {
        if ( !isset($nominations_count) ) {
            return $query;
        }
        if ( $nominations_count == 0) {
            return $query->havingRaw('photo_nominations_count = 0');
        }
        if ( $nominations_count > 0) {
            return $query->havingRaw('photo_nominations_count > 0');
        }
    }

    public function scopeGetByNominationId($query, $nomination_id = null)
    {
        if ( ! empty($nomination_id)) {
            $query->leftJoin('photo_nominations', 'photo_nominations.photo_id', '=', 'photos.id');
            if (is_array($nomination_id)) {
                $query->whereIn(with(new PhotoNomination)->getTable() . '.nomination_id', $nomination_id);
            } else {
                $query->where(with(new PhotoNomination)->getTable() . '.nomination_id', $nomination_id);
            }
        }
        return $query;
    }


    public function scopeGetByCompilationId($query, $compilation_id = null)
    {
        if ( ! empty($compilation_id)) {
            $query->leftJoin('photo_compilations', 'photo_compilations.photo_id', '=', 'photos.id');
            if (is_array($compilation_id)) {
                $query->whereIn(with(new PhotoCompilation)->getTable() . '.compilation_id', $compilation_id);
            } else {
                $query->where(with(new PhotoCompilation)->getTable() . '.compilation_id', $compilation_id);
            }
        }
        return $query;
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($photo) {
//            \Log::info( ' -1 INSIDEstatic::deleting(::' );
            foreach ($photo->getMedia('photo') as $mediaImage) {
//                \Log::info(  varDump($mediaImage->getPath(), ' -1 $mediaImage->getPath()::') );
                if (File::exists($mediaImage->getPath())) {
//                    \Log::info(  varDump($mediaImage->getPath(), ' -1 $mediaImage->getPath()::') );
                    Storage::delete($mediaImage);
                }
            }
        });
    }


    public function owner(){
        return $this->belongsTo('App\Models\User', 'owner_id','id');
    }

    public function photoTags()
    {
        return $this->hasMany('App\Models\PhotoTag');
    }

    public function photoNominations()
    {
        return $this->hasMany('App\Models\PhotoNomination');
    }

    public function photoCompilations()
    {
        return $this->hasMany('App\Models\PhotoCompilation');
    }

    public function photoLikes()
    {
        return $this->hasMany('App\Models\PhotoLike');
    }

    public function photoFavorites()
    {
        return $this->hasMany('App\Models\PhotoFavorite');
    }


    public static function getPhotoValidationRulesArray(
        $photo_id = null,
        array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique(with(new Photo)->getTable())->ignore($photo_id),
            ],

            'owner_id'   => 'required|exists:' . (with(new User)->getTable()) . ',id',

            'slug' => [
                'required',
                'string',
                'max:105',
                Rule::unique(with(new Photo)->getTable())->ignore($photo_id),
            ],
            'active' => 'nullable',
            'published_at'           => 'required|datetime',
        ];

        foreach ($skipFieldsArray as $next_field) {
            if ( ! empty($validationRulesArray[$next_field])) {
                unset($validationRulesArray[$next_field]);
            }
        }

        return $validationRulesArray;
    }

}
