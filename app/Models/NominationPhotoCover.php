<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NominationPhotoCover extends Model
{
    use HasFactory;

    protected $table = 'nomination_photo_covers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nomination_id', 'photo_id'];

    public function nomination()
    {
        return $this->belongsTo('App\Models\Nomination');
    }
    public function scopeGetByNominationId($query, $nomination_id = null)
    {
        if ( ! empty($nomination_id)) {
            $query->where(with(new NominationPhotoCover)->getTable() . '.nomination_id', $nomination_id);
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
            $query->leftJoin('photos', 'photos.id', '=', 'nomination_photo_covers.photo_id');
            $query->where(with(new Photo)->getTable() . '.active', $active);
        }
        return $query;
    }

    public function scopeGetByPhotoId($query, $photo_id = null)
    {
        if ( ! empty($photo_id)) {
            $query->where(with(new NominationPhotoCover)->getTable() . '.photo_id', $photo_id);
        }

        return $query;
    }

    public static function getNominationPhotoCoverValidationRulesArray($photo_id = null): array
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

