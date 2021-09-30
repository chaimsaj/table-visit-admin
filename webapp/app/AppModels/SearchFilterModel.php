<?php


namespace App\AppModels;


use Illuminate\Support\Collection;

class SearchFilterModel
{
    public Collection $place_types;
    public Collection $place_features;
    public Collection $place_music;

    /**
     * @return Collection
     */
    public function getPlaceTypes(): Collection
    {
        return $this->place_types;
    }

    /**
     * @param Collection $place_types
     */
    public function setPlaceTypes(Collection $place_types): void
    {
        $this->place_types = $place_types;
    }

    /**
     * @return Collection
     */
    public function getPlaceFeatures(): Collection
    {
        return $this->place_features;
    }

    /**
     * @param Collection $place_features
     */
    public function setPlaceFeatures(Collection $place_features): void
    {
        $this->place_features = $place_features;
    }

    /**
     * @return Collection
     */
    public function getPlaceMusic(): Collection
    {
        return $this->place_music;
    }

    /**
     * @param Collection $place_music
     */
    public function setPlaceMusic(Collection $place_music): void
    {
        $this->place_music = $place_music;
    }
}
