<?php

namespace App\Repositories\Interface;

interface NumberingInterface
{
    public function setSeries();
    public function setRunningNumber($series);
    public function getRefNumber($trxType, $isIncrease);
}