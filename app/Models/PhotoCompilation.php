<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoCompilation extends Model
{
    use HasFactory;

    protected $table = 'photo_compilations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['compilation_id', 'photo_id'];

    public function scopeGetById($query, $id = null)
    {
        if ( empty($id) ) {
            return $query;
        }
        return $query->where(with(new PhotoCompilation)->getTable() . '.id', $id);
    }


    public function compilation()
    {
        return $this->belongsTo('App\Models\Compilation');
    }

    public function scopeGetByOwnerId($query, $owner_id = null)
    {
        if ( ! empty($owner_id)) {
            $query->leftJoin('photos', 'photos.id', '=', 'photo_compilations.photo_id');
            if (is_array($owner_id)) {
                $query->whereIn(with(new Photo)->getTable() . '.owner_id', $owner_id);
            } else {
                $query->where(with(new Photo)->getTable() . '.owner_id', $owner_id);
            }
        }
        return $query;
    }

    public function scopeGetByCompilationId($query, $compilation_id = null)
    {
        if ( ! empty($compilation_id)) {
            $query->where(with(new PhotoCompilation)->getTable() . '.compilation_id', $compilation_id);
        }

        return $query;
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo');
    }

    public function scopeGetByPhotoActive($query, $active = null)
    {
        if ( ! empty($active)) {
            $query->leftJoin('photos', 'photos.id', '=', 'photo_compilations.photo_id');
            $query->where(with(new Photo)->getTable() . '.active', $active);
        }
        return $query;
    }


    public function scopeGetByPhotoId($query, $photo_id = null)
    {
        if ( ! empty($photo_id)) {
            $query->where(with(new PhotoCompilation)->getTable() . '.photo_id', $photo_id);
        }

        return $query;
    }

    public static function getPhotoCompilationValidationRulesArray($photo_id = null): array
    {
        $validationRulesArray = [
            'photo_id'   => 'required|exists:' . (with(new Photo)->getTable()) . ',id',
            'compilation_id' => 'required|exists:' . (with(new Compilation)->getTable()) . ',id',
        ];

        return $validationRulesArray;
    }

    public static function getValidationMessagesArray(): array
    {
        return [
            'photo_id.required'   => 'Photo is required',
            'compilation_id.required' => 'Compilation is required',
        ];
    }


}

