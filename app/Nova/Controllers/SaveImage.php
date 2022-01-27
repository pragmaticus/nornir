<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpseclib3\File\ASN1\Maps\UniqueIdentifier;

class SaveImage
{
    /**
     * Store the incoming file upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $attribute
     * @param  string  $requestAttribute
     * @param  string  $disk
     * @param  string  $storagePath
     * @return string
     */
    public function __invoke(Request $request, $model, $attribute, $requestAttribute, $disk, $storagePath)
    {

        $file = $request->file('cover');

        $out = array(
            'name' => uniqid(),
            'ext' => ".".$file->getClientOriginalExtension(),
            'path' => Storage::disk($disk)->path('')
        );

        $image = Image::make($file);

        $image->crop(600, 600);
        $image->save($out['path'].$out['name'].$out['ext'], 80);

        $image->resize(400, 400);
        $image->save($out['path'].$out['name']."_m".$out['ext'], 80);

        $image->resize(200, 200);
        $image->save($out['path'].$out['name']."_s".$out['ext'], 80);

        return $out['name'].$out['ext'];
    }
}
