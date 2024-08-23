<?php

namespace App\Repositories\Interface\WarehouseInte;

interface BeginningBalanceInterface
{

    public function index($request);
    public function getAll($request, $trxType);

}
