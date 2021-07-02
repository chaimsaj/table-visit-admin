<?php


namespace App\Helpers;

use Illuminate\Support\Facades\File;

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
}
