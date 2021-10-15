<?php


namespace App\Helpers;

use App\Core\MediaSizeEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class MediaHelper
{
    static function defaultImage(): string
    {
        return 'no-image-available.png';
    }

    static function getPlacesPath(): string
    {
        return 'images/places/';
    }

    static function getUsersPath(): string
    {
        return 'images/users/';
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

    static function deleteUsersImage(string $image = null): void
    {
        if (isset($image)) {
            $image_path = public_path(MediaHelper::getUsersPath()) . '/' . $image;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    static function getImageUrl(string $path, string $file_name, $size = MediaSizeEnum::small): string
    {
        $exists = false;

        if (!empty($file_name)) {
            $local = public_path($path) . $file_name;
            $remote = $path . $file_name;

            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path));
            }

            if (!File::exists($local)) {
                $exists = GoogleStorageHelper::download($local, $remote);
            } else
                $exists = true;
        }

        if ($exists)
            return URL::to('media/' . MediaSizeEnum::toString($size) . '/' . $file_name);

        return URL::to('media/' . MediaSizeEnum::toString($size) . '/' . MediaHelper::defaultImage());
    }

    static function save(UploadedFile $file, string $path, string $name)
    {
        /*$this->validate($request, [
            'name' => 'required',
            'imgFile' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);*/

        $local = public_path($path);

        if (!File::exists($local)) {
            File::makeDirectory($local);
        }

        $file_name = $name . '.' . $file->getClientOriginalExtension();

        $local = $local . $file_name;
        $remote = $path . $file_name;

        // original
        Image::make($file)->save($local);
        GoogleStorageHelper::upload($local, $remote);

        // large
        // MediaHelper::save_thumb($original, $path, $name, 480, 360, $extension);

        // medium
        // MediaHelper::save_thumb($original, $path, $name, 240, 180, $extension);

        // small
        // MediaHelper::save_thumb($original, $path, $name, 120, 90, $extension);

        // square
        // MediaHelper::save_thumb($original, $path, $name, 250, 250, $extension);
    }

    static function save_thumb(string $original, string $path, string $name, int $width, int $height, string $extension)
    {
        Image::make($original)->fit($width, $height, function ($callback) {
            $callback->aspectRatio();
        })->save($path . $name . '_' . $width . '_' . $height . '.' . $extension);
    }
}
