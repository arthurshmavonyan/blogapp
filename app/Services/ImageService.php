<?php

namespace App\Services;

use Storage;
use App\Image;

class ImageService {

    public static function save ($file, $model) {
        $image = new Image;
        $image->src = substr_replace(($file->store('public/images')), 'storage', 0, 6);
        $image->save();
        $model->images()->save($image);

        return $image;
    }

    public static function delete ($path, $model) {
        Storage::delete(substr_replace($path, 'public', 0, 7));
        $model->delete();
    }
}
