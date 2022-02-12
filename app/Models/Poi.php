<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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

        if (array_key_exists('cover', $dirty)) {

            $originalCover = $model->getOriginal('cover');

            if ($model->cover) {
                self::saveImageVariants($model->cover);
                if ($originalCover) self::deleteImageVariants($originalCover);
            } else {
                if ($originalCover) self::deleteImageVariants($originalCover);
            }
        }
    }


    private static function saveImageVariants ($filename) {

        $path = Storage::disk('public-img-covers')->path('');

        $image = Image::make($path.$filename);

        $image->resize(1200, 628);
        $image->save($path.$filename, 80);

        $image->resize(600, 314);
        $image->save($path.'m_'.$filename, 80);

        $image->resize(300, 157);
        $image->save($path.'s_'.$filename, 80);
    }

    private static function deleteImageVariants($filename) {

        $path = Storage::disk('public-img-covers')->path('');

        File::delete([
            $path.$filename,
            $path.'m_'.$filename,
            $path.'s_'.$filename
        ]);
    }


    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            self::onCreatingAndUpdating($model);
        });

        self::created(function($model){
        });

        self::updating(function($model){
            self::onCreatingAndUpdating($model);
        });

        self::updated(function($model){
        });

        self::deleting(function($model){
        });

        self::deleted(function($model){
            if ($model->cover) self::deleteImageVariants($model->cover);
        });
    }
}
