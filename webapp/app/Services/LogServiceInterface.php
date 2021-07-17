<?php


namespace App\Services;

use Throwable;

interface LogServiceInterface
{
    public function save(Throwable $ex): void;
}
