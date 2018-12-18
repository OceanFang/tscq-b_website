<?php

namespace App\Library;

use Illuminate\Http\Request;
use App\Services\IDMangerService;

class App
{
    public function hourOption($selected = null)
    {
        $option = '';
        if ($selected === null) {
            $selected = date('H', time() + 600);
        }

        for ($i = 0; $i < 24; ++$i) {
            $hour = str_pad($i, 2, 0, STR_PAD_LEFT);

            if ($selected === $hour) {
                $option .= '<option value="'.$hour.'" selected>'.$hour.'</option>';
            } else {
                $option .= '<option value="'.$hour.'">'.$hour.'</option>';
            }
        }

        return $option;
    }

    public function minOption($selected = null)
    {
        $option = '';
        if ($selected === null) {
            $selected = date('i', time() + 600);
        }

        for ($i = 0; $i < 60; ++$i) {
            $mins = str_pad($i, 2, 0, STR_PAD_LEFT);

            if ($selected === $mins) {
                $option .= '<option value="'.$mins.'" selected>'.$mins.'</option>';
            } else {
                $option .= '<option value="'.$mins.'">'.$mins.'</option>';
            }
        }

        return $option;
    }

    public function dateOption($inverval = 14)
    {
        $option = '';
        for ($i = 0; $i < $inverval; ++$i) {
            $date = date('Y-m-d', strtotime("+{$i} day"));
            $option .= '<option value="'.$date.'">'.$date.'</option>';
        }

        return $option;
    }

    /**
     * Build option string.
     *
     * @param array $datas
     *
     * @return string
     */
    public function makeOption($datas = array())
    {
        $option = '';

        foreach ($datas as $key => $data) {
            $option .= '<option value="'.$key.'">'.$data.'</option>';
        }

        return $option;
    }

    public function getTestIDList($column = 'gid')
    {
        $list = '';
        $request = new Request();
        $IDM = new IDMangerService($request);
        $datas = $IDM->getTestUidList($column);
        foreach ($datas as $key => $val) {
            if ($key > 0) {
                $list .= ',';
            }

            $list .= $val->$column;
        }

        return $list;
    }
}
