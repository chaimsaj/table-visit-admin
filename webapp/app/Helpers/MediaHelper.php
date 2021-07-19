<?php


namespace App\Helpers;

use App\Core\MediaSizeEnum;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class MediaHelper
{
    static function getPlacesPath($image = null): string
    {
        $image_path = public_path('images/places');

        if (!File::exists($image_path)) {
            File::makeDirectory($image_path);
        }

        return $image_path . '/' . $image;
    }

    static function deletePlacesImage($image): void
    {
        if (isset($image)) {
            $image_path = MediaHelper::getPlacesPath() . '/' . $image;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    static function getUsersPath($image = null): string
    {
        $image_path = public_path('images/users');

        if (!File::exists($image_path)) {
            File::makeDirectory($image_path);
        }

        return $image_path . '/' . $image;
    }

    static function deleteUsersImage($image): void
    {
        if (isset($image)) {
            $image_path = MediaHelper::getUsersPath() . '/' . $image;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    static function getImageUrl($image, $size = MediaSizeEnum::small): string
    {
        if (isset($image))
            return URL::to('media/' . MediaSizeEnum::toString($size) . '/' . $image);
        else
            return URL::to('media/' . MediaSizeEnum::toString(MediaSizeEnum::small) . '/no-image-available.png');

        // MediaHelper::getImageUrl(asset('/assets/images/default-image.jpeg'));
    }
}
