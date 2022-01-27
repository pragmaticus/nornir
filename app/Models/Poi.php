<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Poi extends Model {

    use HasFactory;

    protected $fillable = [
        'description'
    ];

    private static function onCreatingAndUpdating ($model) {

        $dirty = $model->getDirty();

        if (array_key_exists('description', $dirty)) {
            $model->description = strip_tags($model->description);
        }

        if (array_key_exists('cover', $dirty) && $model->cover) {
            self::saveImageVariants($model);
        }
    }

    private static function saveImageVariants ($model) {

        $path = Storage::disk('public-img-covers')->path('');

        $image = Image::make($path.$model->cover);

        $image->resize(400, 400);
        $image->save($path.'m_'.$model->cover, 80);

        $image->resize(200, 200);
        $image->save($path.'s_'.$model->cover, 80);
    }


    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            self::onCreatingAndUpdating($model);
        });

        self::created(function($model){
            // ... code here
        });

        self::updating(function($model){
            self::onCreatingAndUpdating($model);
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }
}
