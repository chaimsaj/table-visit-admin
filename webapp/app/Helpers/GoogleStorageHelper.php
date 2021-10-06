<?php


namespace App\Helpers;


use Google\Cloud\Storage\StorageClient;

class GoogleStorageHelper
{
    static function upload(string $image)
    {
        $storage = new StorageClient([
            'keyFilePath' => public_path(env('GOOGLE_CLOUD_KEY_FILE_PATH', ''))
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET', ''));

        $bucket->upload(fopen($image, 'r'),
            [
                'name' => $image
            ]);
    }

    static function download(string $file)
    {
        $storage = new StorageClient([
            'keyFilePath' => public_path(env('GOOGLE_CLOUD_KEY_FILE_PATH', ''))
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET', ''));

        $object = $bucket->object($file);

        if (isset($object))
            $object->downloadToFile($file);
    }

    static function delete(string $file)
    {
        $storage = new StorageClient([
            'keyFilePath' => public_path(env('GOOGLE_CLOUD_KEY_FILE_PATH', ''))
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET', ''));

        $object = $bucket->object($file);

        if (isset($object))
            $object->delete();
    }
}
