<?php

namespace App\Http\Api\Twilio;

use App\AppModels\ApiModel;
use App\AppModels\KeyValueModel;
use App\Http\Api\Base\ApiController;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

class NotificationsController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }
}
