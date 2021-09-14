<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\StripeModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Throwable;

class PaymentsController extends ApiController
{
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->paymentRepository = $paymentRepository;
    }

    public function stripe(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'amount' => ['required', 'numeric'],
                'name' => ['required', 'string'],
                'email' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                $response->setError($validator->getMessageBag());
                return response()->json($response);
            }

            if (Auth::check()) {
                $user = Auth::user();

                Stripe::setApiKey('sk_test_3vFmt8WPsBjG0JaWElA4ydbT');

                $customer = Customer::create(['email' => $request->get('email'), 'name' => $request->get('name')]);

                $ephemeralKey = EphemeralKey::create(
                    ['customer' => $customer->id],
                    ['stripe_version' => '2020-08-27']
                );

                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->get('amount'),
                    'currency' => 'usd',
                    'customer' => $customer->id
                ]);

                $stripe = new StripeModel();
                $stripe->paymentIntent = $paymentIntent->client_secret;
                $stripe->ephemeralKey = $ephemeralKey->secret;
                $stripe->customer = $customer->id;

                $response->setData($stripe);

                /*return $response->withJson([
                    'paymentIntent' => $paymentIntent->client_secret,
                    'ephemeralKey' => $ephemeralKey->secret,
                    'customer' => $customer->id
                ])->withStatus(200);*/
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
