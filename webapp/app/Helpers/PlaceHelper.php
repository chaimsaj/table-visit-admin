<?php

namespace App\Helpers;

use App\Core\MediaSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceHelper
{
    public static function load(Model $item): Model
    {
        $image = $item->image_path;

        $item->image_path = MediaHelper::getImageUrl($image, MediaSizeEnum::medium);
        $item->large_image_path = MediaHelper::getImageUrl($image, MediaSizeEnum::large);
        $item->floor_plan_path = MediaHelper::getImageUrl($item->floor_plan_path, MediaSizeEnum::large);
        $item->food_menu_path = MediaHelper::getImageUrl($item->food_menu_path, MediaSizeEnum::large);

        $item->place_rating_count = rand(0, 100);
        $item->place_rating_avg = rand(1, 5);
        $item->place_type_name = "Venue";

        return $item;
    }
}
