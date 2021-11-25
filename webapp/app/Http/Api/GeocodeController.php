<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Services\LogServiceInterface;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\JsonResponse;
use Throwable;

class GeocodeController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function resolve(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            //dd(Geocoder::geocode('1778 Ellsworth industrial Blvd Atlanta GA')->get());

            $data = Geocoder::geocode('1778 Ellsworth industrial Blvd Atlanta GA')->get();

            // var_dump($data->first());

            if ($data->count() > 0) {
                // $data->first()->getCoordinates()->getLatitude()
                // $data->first()->getCoordinates()->getLongitude()
                // $data->first()->getCoordinates()->getLocality()
                // $data->first()->getCoordinates()->getLongitude()
                // $data->first()->getCoordinates()->getLongitude()

                $response->setError();
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
