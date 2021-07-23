<?php


namespace App\Http\AdminApi;

use App\AppModels\ApiModel;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Temp\CityImport;
use App\Models\Temp\CountryImport;
use App\Models\Temp\StateImport;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Throwable;

class MainController
{
    private CountryRepositoryInterface $countryRepository;
    private StateRepositoryInterface $stateRepository;
    private CityRepositoryInterface $cityRepository;

    public function __construct(CountryRepositoryInterface $countryRepository,
                                StateRepositoryInterface $stateRepository,
                                CityRepositoryInterface $cityRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }

    public function _bak(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $countries_import = CountryImport::all();
            $states_import = StateImport::all();
            $cities_import = CityImport::all();

            foreach ($countries_import as $import) {

                $db = new Country();

                $db->name = $import->countryName;
                $db->iso_code = $import->countryCode;
                $db->currency_code = $import->currencyCode;
                $db->iso_numeric = $import->isoNumeric;
                $db->north = $import->north;
                $db->south = $import->south;
                $db->east = $import->east;
                $db->west = $import->west;
                $db->capital_name = $import->capital;
                $db->continent_name = $import->continentName;
                $db->continent_code = $import->continent;
                $db->iso_alpha = $import->isoAlpha3;
                $db->geo_name_id = $import->geonameId;
                $db->display_order = $import->id;
                $db->published = 1;
                $db->show = 1;

                $this->countryRepository->save($db);
            }

            foreach ($states_import as $import) {
                $db = new State();

                $db->name = $import->STATE_NAME;
                $db->iso_code = $import->STATE_CODE;
                $db->display_order = $import->ID;
                $db->country_id = 233;
                $db->published = 1;
                $db->show = 1;

                $this->stateRepository->save($db);
            }

            foreach ($cities_import as $import) {
                $db = new City();

                $db->name = $import->CITY;
                $db->iso_code = "";
                $db->county = $import->COUNTY;
                $db->display_order = $import->ID;
                $db->latitude = $import->LATITUDE;
                $db->longitude = $import->LONGITUDE;
                $db->state_id = $import->ID_STATE;
                $db->country_id = 233;
                $db->published = 1;
                $db->show = 1;

                $this->cityRepository->save($db);
            }

        } catch (Throwable $ex) {
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
