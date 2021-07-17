<?php


namespace App\Services;

use App\Models\Log;
use App\Repositories\LogRepositoryInterface;
use Throwable;

class LogService implements LogServiceInterface
{
    private LogRepositoryInterface $repository;

    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(Throwable $ex): void
    {
        Illuminate\Support\Facades\Log::error($ex->getMessage());

        try {
            $db = new Log();

            $message = $ex->getMessage();

            if (strlen($message) > 250)
                $message = substr($message, 0, 250);

            $trace = $ex->getTraceAsString();

            if (strlen($trace) > 750)
                $trace = substr($trace, 0, 750);

            $db->code = strval($ex->getCode());
            $db->error = $message;
            $db->trace = $trace;
            $db->published = 1;

            $this->repository->save($db);
        } catch (Throwable $e) {
            Illuminate\Support\Facades\Log::error($e->getMessage());
        }
    }
}
