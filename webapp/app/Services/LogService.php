<?php


namespace App\Services;

use App\Repositories\LogRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models;
use Throwable;

class LogService implements LogServiceInterface
{
    private LogRepositoryInterface $repository;

    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(Throwable $ex, $user_id = null): void
    {
        Log::error($ex->getMessage());

        try {

            if ($user_id == null) {
                if (Auth::check() && Auth::user() != null)
                    $user_id = Auth::user()->id;
            }

            $db = new Models\Log();

            $message = $ex->getMessage();

            if (strlen($message) > 250)
                $message = substr($message, 0, 250);

            $trace = $ex->getTraceAsString();

            if (strlen($trace) > 750)
                $trace = substr($trace, 0, 750);

            $db->code = strval($ex->getCode());
            $db->error = $message;
            $db->trace = $trace;
            $db->user_id = $user_id;
            $db->published = 1;

            $this->repository->save($db);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
