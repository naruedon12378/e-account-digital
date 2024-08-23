<?php

namespace App\Repositories;

use App\Models\RunningNumber;
use App\Models\Series;
use App\Repositories\Interface\NumberingInterface;
use Carbon\Carbon;

class NumberingRepository implements NumberingInterface
{
    public function setSeries()
    {
        $transactionTypes = [
            'QO',
            'TDN',
            'IV',
            'IVT',
            'DN',
            'RE',
            'RT',
            'TIV',
            'CN',
            'CNT',
            'BN',
            'DBN',
            'DBNT',
            'PO',
            'POA',
            'PR',
            'EXP',
            'CNX',
            'CPN',
            'PA',
        ];
        $data = [
            'symbol' => '-',
            'year' => 1,
            'month' => 1,
            'date' => 0,
            'digit' => 5,
            'company_id' => 1,
        ];

        foreach ($transactionTypes as $value) {
            $data['transaction_type'] = $value;
            $data['prefix'] = $value;
            $series = Series::create($data);
            $this->setRunningNumber($series);
        }
    }

    public function setRunningNumber($series)
    {
        $date = Carbon::now();
        $currYear = $date->format('Y');

        $running = RunningNumber::where([
            ['series_id', $series->id],
            ['year', $currYear]
        ])->first();

        if (!$running) {
            $running = RunningNumber::create([
                'series_id' => $series->id,
                'month01' => 1,
                'month02' => 1,
                'month03' => 1,
                'month04' => 1,
                'month05' => 1,
                'month06' => 1,
                'month07' => 1,
                'month08' => 1,
                'month09' => 1,
                'month10' => 1,
                'month11' => 1,
                'month12' => 1,
                'year' => $currYear
            ]);
        }
        return $running;
    }

    private function years()
    {
        $years = [
            1 => date('Y'),
            2 => date('Y') + 543,
            3 => date('y'),
            4 => date('y') + 43,
        ];
        return $years;
    }

    public function getRefNumber($trxType, $isIncrease)
    {
        $date = Carbon::now();
        $series = Series::where([
            ['company_id', 1],
            ['transaction_type', $trxType]
        ])->first();

        if ($series) {
            $currYear = $this->years()[$series->year];
            $currMonth = $series->month ? $date->format('m') : '';
            $currDate = $series->date ? $date->format('d') : '';
            $running = $this->setRunningNumber($series);

            // get subfix
            $prefix = $series->prefix;
            $subfix = $series->symbol . $currYear . $currMonth . $currDate;
            $length = $series->digit;

            // get running number
            $colMonth = 'month' . $date->format('m');
            $currNum = $running->$colMonth;

            // increase running number
            if ($isIncrease) {
                $running->$colMonth = $currNum + 1;
                $running->save();
            }

            $reference = $prefix . $subfix . str_pad($currNum, $length, '0', STR_PAD_LEFT);
            return $reference;
        }
        return null;
    }
}
