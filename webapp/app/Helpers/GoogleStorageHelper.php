<?php


namespace App\Helpers;


use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\File;
use Psr\Http\Message\StreamInterface;

class GoogleStorageHelper
{
    static function upload()
    {
        $storage = new StorageClient([
            'keyFilePath' => public_path('key/google-storage.json'),
        ]);

        $bucket = $storage->bucket('table-visit-storage');
        $file = public_path('images/shared/no-image-available.png');
        $file_name = 'shared/no-image-available.png';

        $bucket->upload(fopen($file, 'r'),
            [
                'name' => $file_name
            ]);
    }

    static function download()
    {
        $storage = new StorageClient([
            'keyFilePath' => public_path('key/google-storage.json'),
        ]);

        $bucket = $storage->bucket('table-visit-storage');
        $file_name = 'shared/no-image-available.png';
        $object = $bucket->object($file_name);

        $object->downloadToFile(public_path('images/no_image_available.png'));
    }
}
