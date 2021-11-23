<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\StripeModel;
use App\Core\PaymentStatusEnum;
use App\Core\PaymentTypeEnum;
use App\Http\Api\Base\ApiController;
use App\Models\BookingGuest;
use App\Models\Payment;
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
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository,
                                UserRepositoryInterface    $userRepository,
                                BookingRepositoryInterface $bookingRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function list(int $booking_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $query = $this->paymentRepository->loadByBooking($booking_id);

                if (isset($query))
                    $response->setData($query);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
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

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                try {

                    $user = Auth::user();
                    $booking = $this->bookingRepository->find($request->get('booking_id'));

                    if (isset($user) && isset($booking)) {
                        $payment = new Payment();
                        $payment->amount = $request->get('amount');
                        $payment->date = now();
                        $payment->payment_type = PaymentTypeEnum::Table;
                        $payment->payment_status = PaymentStatusEnum::Success;
                        $payment->payment_method = $request->get('payment_method');
                        $payment->place_id = $booking->place_id;
                        $payment->booking_id = $booking->id;;
                        $payment->user_id = $user->id;
                        $payment->tenant_id = intval($booking->tenant_id);
                        $payment->published = true;
                        $payment->deleted = false;

                        $this->paymentRepository->save($payment);

                        // Update Booking
                        $booking->paid_amount += $payment->amount;
                        $this->bookingRepository->save($booking);
                    }
                } catch (Throwable $ex) {
                    $this->logger->save($ex);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $this->paymentRepository->delete($id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
