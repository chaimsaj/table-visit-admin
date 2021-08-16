<?php


namespace App\Http\AdminApi\Base;

use App\Services\LogServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AdminApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LogServiceInterface $logger;

    public function __construct(LogServiceInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function order()
    {
        $order_param = request()->get('order');

        $order = 'asc';

        if (isset($order_param))
            $order = $order_param[0]['dir'] ?? 'asc';

        return $order;
    }

    protected function orderColumn(): int
    {
        $order_param = request()->get('order');

        $order_column = '0';

        if (isset($order_param))
            $order_column = $order_param[0]['column'] ?? '0';

        return intval($order_column);
    }
}
