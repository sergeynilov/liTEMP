<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['address', 'postal_code', 'country', 'federal_district', 'region_type', 'region', 'area_type',
                           'area', 'city_type', 'city', 'settlement_type', 'settlement', 'kladr_id', 'fias_id',
                           'fias_level', 'capital_marker', 'okato', 'oktmo', 'tax_office', 'timezone', 'geo_lat',
                           'geo_lon', 'population', 'foundation_year', 'photo_id'];


    public function scopeGetByRegion($query, $region = null)
    {
        if (!isset($region) or strlen($region) == 0) {
            return $query;
        }
        return $query->where(with(new City)->getTable().'.region', $region);
    }

    public function userProfiles()
    {

        return $this->hasMany('App\Models\UserProfile', 'forum_id', 'id');
    }
    /*     public function forumThreads()
    {
        return $this->hasMany('App\ForumThread', 'forum_id', 'id');
    }
 */


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($city) {
        });
    }

    public static function getCitiesSelectionArray($return_array= false) :array {
        $cities = City::orderBy('city','asc')->get();
        $citiesSelectionArray= [];
        foreach( $cities as $nextCity ) {
            if(!$return_array) {
                if(!empty($nextCity->id) and !empty($nextCity->city)) {
                    $citiesSelectionArray[$nextCity->id] = $nextCity->city;
                }
            } else {
                if( !empty($nextCity->address)) {
                    $citiesSelectionArray[] = [
                        'code'    => $nextCity->id,
                        'label' => /*  $nextCity->id .' : '  .  */ $nextCity->address,
                    ];
                    continue;
                }


            }
        }
        return $citiesSelectionArray;
    }


}
