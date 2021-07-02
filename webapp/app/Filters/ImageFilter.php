<?php


namespace App\Filters;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class ImageFilter implements FilterInterface
{
    public function applyFilter(Image $image): Image
    {
        return $image->fit(120, 90)->encode('jpg', 20);
    }
}
