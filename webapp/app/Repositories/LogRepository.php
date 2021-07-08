<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Log;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class LogRepository extends BaseRepository implements LogRepositoryInterface
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->get();
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

            $db->save();
        } catch (Throwable $e) {
            Illuminate\Support\Facades\Log::error($e->getMessage());
        }
    }
}
