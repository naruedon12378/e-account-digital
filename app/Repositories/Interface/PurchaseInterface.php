<?php

namespace App\Repositories\Interface;

interface PurchaseInterface
{
    public function getAll($request, $trxType);
    public function getStatusTab($datas, $status, $trxType);
    public function save($request, $trxType);
    public function getOne($id, $trxType);
    public function getTabs($id, $trxType);
    public function getItems($id, $trxType);
    public function getHistory($id, $trxType);
    public function delete($id, $trxType);
}
