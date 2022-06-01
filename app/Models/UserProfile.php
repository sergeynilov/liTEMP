<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'users_profile';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeGetByCityId($query, $city_id = null)
    {
        if ( ! empty($city_id)) {
            $query->where(with(new UserProfile)->getTable() . '.city_id', $city_id);
        }
        return $query;
    }

    public function scopeGetByUserId($query, $user_id = null)
    {
        if ( ! empty($user_id)) {
            $query->where(with(new UserProfile)->getTable() . '.user_id', $user_id);
        }
        return $query;
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City' );
    }

    public function user()
    {
        return $this->HasOne('App\Models\User');
    }


    public static function getUserProfileValidationRulesArray($user_profile_id = null): array
    {
        $validationRulesArray = [
            'user_id'   => 'required|exists:' . (with(new User)->getTable()) . ',id',
        ];

        return $validationRulesArray;
    }

    public static function getValidationMessagesArray(): array
    {
        return [
            'user_id.required'   => 'User is required',
        ];
    }


}

