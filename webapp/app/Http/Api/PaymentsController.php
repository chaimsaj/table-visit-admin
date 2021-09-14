<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\StripeModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
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
    private UserRepositoryInterface $userRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository,
                                UserRepositoryInterface    $userRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
    }

    public function stripe(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'amount' => ['required', 'numeric']
            ]);

            if ($validator->fails()) {
                $response->setError($validator->getMessageBag());
                return response()->json($response);
            }

            if (Auth::check()) {
                $user = Auth::user();

                Stripe::setApiKey(env('STRIPE_API_KEY', ''));

                if (!isset($user->payment_data)) {
                    $full_name = $user->name . ' ' . $user->last_name;
                    $customer = Customer::create(['email' => $user->email, 'name' => $full_name]);
                    $customer_id = $customer->id;
                    $user->payment_data = $customer->id;

                    $db = $this->userRepository->find($user->id);

                    if ($db) {
                        $db->payment_data = $customer_id;
                        $this->userRepository->save($db);
                    }
                } else
                    $customer_id = $user->payment_data;

                $ephemeralKey = EphemeralKey::create(
                    ['customer' => $customer_id],
                    ['stripe_version' => '2020-08-27']
                );

                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->get('amount'),
                    'currency' => 'usd',
                    'customer' => $customer_id
                ]);

                $stripe = new StripeModel();
                $stripe->paymentIntent = $paymentIntent->client_secret;
                $stripe->ephemeralKey = $ephemeralKey->secret;
                $stripe->customer = $customer_id;

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
