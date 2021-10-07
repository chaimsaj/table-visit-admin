<?php


namespace App\Helpers;

use App\Core\MediaSizeEnum;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class MediaHelper
{
    static function getPlacesPath(string $image = null): string
    {
        $image_path = 'images/places';
        $public_path = public_path($image_path);

        if (!File::exists($public_path)) {
            File::makeDirectory($public_path);
        }

        return $image_path . '/' . $image;
    }

    static function deletePlacesImage(string $image = null): void
    {
        if (isset($image)) {
            $image_path = public_path(MediaHelper::getPlacesPath()) . '/' . $image;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    static function getUsersPath(string $image = null): string
    {
        $image_path = 'images/users';
        $public_path = public_path($image_path);

        if (!File::exists($public_path)) {
            File::makeDirectory($public_path);
        }

        return $image_path . '/' . $image;
    }

    static function deleteUsersImage(string $image = null): void
    {
        if (isset($image)) {
            $image_path = public_path(MediaHelper::getUsersPath()) . '/' . $image;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    static function getImageUrl(string $image = null, $size = MediaSizeEnum::small): string
    {
        if (isset($image)) {
            if (!File::exists(MediaHelper::getPlacesPath($image))) {
                // GoogleStorageHelper::download(MediaHelper::getPlacesPath($image));
            } else
                return URL::to('media/' . MediaSizeEnum::toString($size) . '/' . $image);
        }

        return URL::to('media/' . MediaSizeEnum::toString($size) . '/no-image-available.png');
    }
}
