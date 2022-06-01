<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoFavorite extends Model
{
    use HasFactory;

    protected $table = 'photo_favorites';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'photo_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeGetByUserId($query, $user_id = null)
    {
        if ( ! empty($user_id)) {
            $query->where(with(new PhotoFavorite)->getTable() . '.user_id', $user_id);
        }
        return $query;
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo');
    }

    public function scopeGetByPhotoId($query, $photo_id = null)
    {
        if ( ! empty($photo_id)) {
            $query->where(with(new PhotoFavorite)->getTable() . '.photo_id', $photo_id);
        }
        return $query;
    }

    public static function getPhotoFavoriteValidationRulesArray($photo_id = null): array
    {
        $validationRulesArray = [
            'photo_id'   => 'required|exists:' . (with(new Photo)->getTable()) . ',id',
            'user_id' => 'required|exists:' . (with(new User)->getTable()) . ',id',
        ];

        return $validationRulesArray;
    }

    public static function getValidationMessagesArray(): array
    {
        return [
            'photo_id.required'   => 'Photo is required',
            'user_id.required' => 'User is required',
        ];
    }


}

