<?php


namespace App\Helpers;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class MediaHelper implements FilterInterface
{
    public function applyFilter(Image $image): Image
    {
        return $image->fit(120, 90)->encode('jpg', 20);
    }
}
