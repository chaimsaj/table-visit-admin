<?php

namespace App\Helpers;

use App\Core\MediaSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceHelper
{
    public static function load(Model $item, Collection $place_types): Model
    {
        $image = $item->image_path;

        $item->image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $image, MediaSizeEnum::medium);
        $item->large_image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $image, MediaSizeEnum::large);
        $item->floor_plan_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->floor_plan_path, MediaSizeEnum::large);
        $item->food_menu_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->food_menu_path, MediaSizeEnum::large);

        $item->place_rating_count = 0;
        $item->place_rating_avg = 0;

        if ($place_types->count() > 0)
            $item->place_type_name = $place_types[0]->name;
        else
            $item->place_type_name = "Venue";

        return $item;
    }
}
