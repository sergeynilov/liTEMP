<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoNomination extends Model
{
    use HasFactory;

    protected $table = 'photo_nominations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nomination_id', 'photo_id'];

    public function nomination()
    {
        return $this->belongsTo('App\Models\Nomination');
    }

    public function scopeGetByOwnerId($query, $owner_id = null)
    {
        if ( ! empty($owner_id)) {
            $query->leftJoin('photos', 'photos.id', '=', 'photo_nominations.photo_id');
            if (is_array($owner_id)) {
                $query->whereIn(with(new Photo)->getTable() . '.owner_id', $owner_id);
            } else {
                $query->where(with(new Photo)->getTable() . '.owner_id', $owner_id);
            }
        }
        return $query;
    }

    public function scopeGetByNominationId($query, $nomination_id = null)
    {
        if ( ! empty($nomination_id)) {
            $query->where(with(new PhotoNomination)->getTable() . '.nomination_id', $nomination_id);
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
            $query->leftJoin('photos', 'photos.id', '=', 'photo_nominations.photo_id');
            $query->where(with(new Photo)->getTable() . '.active', $active);
        }
        return $query;
    }


    public function scopeGetByPhotoId($query, $photo_id = null)
    {
        if ( ! empty($photo_id)) {
            $query->where(with(new PhotoNomination)->getTable() . '.photo_id', $photo_id);
        }

        return $query;
    }

    public static function getPhotoNominationValidationRulesArray($photo_id = null): array
    {
        $validationRulesArray = [
            'photo_id'   => 'required|exists:' . (with(new Photo)->getTable()) . ',id',
            'nomination_id' => 'required|exists:' . (with(new Nomination)->getTable()) . ',id',
        ];

        return $validationRulesArray;
    }

    public static function getValidationMessagesArray(): array
    {
        return [
            'photo_id.required'   => 'Photo is required',
            'nomination_id.required' => 'Nomination is required',
        ];
    }


}

