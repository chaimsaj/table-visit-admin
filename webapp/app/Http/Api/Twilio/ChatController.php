<?php

namespace App\Http\Api\Twilio;

// require_once 'vendor/twilio/sdk/src/Twilio/autoload.php'; // Loads the library

use App\AppModels\ApiModel;
use App\AppModels\KeyValueModel;
use App\Http\Api\Base\ApiController;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

class ChatController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function token(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();
                // Required for all Twilio access tokens
                $twilioAccountSid = 'ACffd9af3534c4d7e385bfb0dc4197a48e';
                $twilioApiKey = 'SKae8b733842636fcf1125e9cc40fc8f9b';
                $twilioApiSecret = 'YFor12UIcutozv0d2RFSSMEfeYlgA9Aj';

                // Required for Chat grant
                $serviceSid = 'IS75e97e90a9474a13a8572aeadb9fc693';

                // choose a random username for the connecting user
                $identity = $user->email;

                // Create access token, which we will serialize and send to the client
                $token = new AccessToken(
                    $twilioAccountSid,
                    $twilioApiKey,
                    $twilioApiSecret,
                    3600,
                    $identity
                );

                // Create Chat grant
                $chatGrant = new ChatGrant();
                $chatGrant->setServiceSid($serviceSid);

                // Add grant to token
                $token->addGrant($chatGrant);

                // render token to string
                $data = new KeyValueModel();
                $data->setKey('token');
                $data->setValue($token->toJWT());

                $response->setData($data);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
