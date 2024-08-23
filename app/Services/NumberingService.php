<?php

namespace App\Services;

use App\Repositories\Interface\NumberingInterface;

class NumberingService
{
    protected NumberingInterface $number;

    public function __construct(NumberingInterface $number)
    {
        $this->number = $number;
    }

    public function setSeries()
    {
        return $this->number->setSeries();
    }
    public function setRunningNumber($series)
    {
        return $this->number->setRunningNumber($series);
    }

    public function getRefNumber($trxType, $isIncrease = true)
    {
        return $this->number->getRefNumber($trxType, $isIncrease);
    }
   
}
