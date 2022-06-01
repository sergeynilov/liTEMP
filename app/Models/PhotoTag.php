<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoTag extends Model
{
    use HasFactory;

    protected $table = 'photo_tags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['tag_id', 'photo_id'];

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }

    public function scopeGetByTagId($query, $tag_id = null)
    {
        if ( ! empty($tag_id)) {
            $query->where(with(new PhotoTag)->getTable() . '.tag_id', $tag_id);
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
            $query->where(with(new PhotoTag)->getTable() . '.photo_id', $photo_id);
        }

        return $query;
    }

    public static function getPhotoTagValidationRulesArray($photo_id = null): array
    {
        $validationRulesArray = [
            'photo_id'   => 'required|exists:' . (with(new Photo)->getTable()) . ',id',
            'tag_id' => 'required|exists:' . (with(new Tag)->getTable()) . ',id',
        ];

        return $validationRulesArray;
    }

    public static function getValidationMessagesArray(): array
    {
        return [
            'photo_id.required'   => 'Photo is required',
            'tag_id.required' => 'Tag is required',
        ];
    }


}

