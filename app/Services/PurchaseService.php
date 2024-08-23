<?php

namespace App\Services;

use App\Repositories\Interface\PurchaseInterface;

class PurchaseService
{
    protected PurchaseInterface $purchase;

    public function __construct(PurchaseInterface $purchase)
    {
        $this->purchase = $purchase;
    }

    public function getAll($request, $trxType)
    {
        return $this->purchase->getAll($request, $trxType);
    }

    public function getStatusTab($datas, $status, $trxType)
    {
        return $this->purchase->getStatusTab($datas, $status, $trxType);
    }

    public function save($request, $trxType)
    {
        return $this->purchase->save($request, $trxType);
    }

    public function getOne($id, $trxType)
    {
        return $this->purchase->getOne($id, $trxType);
    }

    public function getTabs($id, $trxType)
    {
        return $this->purchase->getTabs($id, $trxType);
    }

    public function getItems($id, $trxType)
    {
        return $this->purchase->getItems($id, $trxType);
    }

    public function getHistory($id, $trxType)
    {
        return $this->purchase->getHistory($id, $trxType);
    }

    public function delete($id, $trxType)
    {
        return $this->purchase->delete($id, $trxType);
    }
}
