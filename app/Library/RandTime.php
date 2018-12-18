<?php
namespace App\Library;

use Carbon\Carbon;

class RandTime
{
    private $times = [];

    public function genTime($params)
    {
        extract($params);
        $result = [];
        list($from, $to) = $this->getRange($params);

        foreach ($batchNum as $key => $batch) {
            if ((int) $batch !== 0) {
                for ($i = 0; $i < $batch; $i++) {
                    $result[][$key] = $this->getTime($from, $to);
                }
            }
        }

        return $result;
    }

    public function genSingleTime($params)
    {
        extract($params);
        $result = [];
        list($from, $to) = $this->getRange($params);

        for ($i = 0; $i < $batchNum; $i++) {
            $result[] = $this->getTime($from, $to);
        }

        return $result;
    }

    private function getRange($params)
    {
        extract($params);
        $from = Carbon::parse("{$batchDate} {$batchHour}:00:00");

        switch ($batchType) {
            case '1':
                $to = Carbon::parse("{$batchDate} 23:59:59")->addDays($batchLimit - 1);
                break;
            case '2':
                $to = $from->copy()->addHours($batchLimit);
                break;
        }

        return [$from->timestamp, $to->timestamp];
    }

    private function getTime($from, $to)
    {
        $timeRand = mt_rand($from, $to);

        if (!in_array($timeRand, $this->times)) {
            $this->times[] = $timeRand;
        } else {
            return $this->getTime($from, $to);
        }

        $time = Carbon::createFromTimeStamp($timeRand);
        $time->second = 25;

        return $time->toDateTimeString();
    }
}