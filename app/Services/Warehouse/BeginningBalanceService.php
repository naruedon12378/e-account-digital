<?php

namespace App\Services\Warehouse;
use App\Repositories\Interface\WarehouseInte\BeginningBalanceInterface;
class BeginningBalanceService
{
    protected BeginningBalanceInterface $beginningBalance;

    public function __construct(BeginningBalanceInterface $beginningBalance)
    {
        $this->beginningBalance = $beginningBalance;
    }

    public function index($request)
    {
        return $this->beginningBalance->index($request);
    }

    public function getAll($request, $trxType)
    {
        return $this->beginningBalance->getAll($request, $trxType);
    }
}
