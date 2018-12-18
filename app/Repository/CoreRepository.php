<?php

namespace App\Repository;

use App\Library\App;
use DB;

abstract class CoreRepository
{
    public function checkFilter($tester_filter = 0, $prefix = '')
    {
        $addCondition = '';
        if ($tester_filter == 1) {
            $app = new App();
            $testers = $app->getTestIDList();
            $addCondition = $prefix.' NOT IN ('.$testers.')';
        }

        return $addCondition;
    }

    public function testerLists($tester_filter = 0, $column = 'gid')
    {
        $lists = [];
        if ($tester_filter == 1) {
            $app = new App();
            $testers = $app->getTestIDList($column);
            if ($testers != '') {
                $lists = explode(',', $testers);
            }
        }

        return $lists;
    }

    public function CalculateNTDValue($amount, $discount, $value = 15)
    {
        return $amount * $value * ((100 - $discount) / 100);
    }

    /**
     * 撈取符合條件的uid.
     *
     * @param string $string  查詢條件
     * @param array  $columns 比對欄位
     * @param string $table   table名稱
     *
     * @return array $lists       結果
     */
    public function compliantLists($string, $columns, $table)
    {
        $lists = [];

        if (trim($string) != '' && !is_null($string)) {
            $query = 'select uid from '.$table.' where (';
            foreach ($columns as $index => $column) {
                if ($index === 0) {
                    $query .= $table.'.'.$column." = '".$string."'";
                } else {
                    $query .= ' OR '.$table.'.'.$column." = '".$string."'";
                }
            }
            $query .= ') and uid in (select uid from pending_proxy_users where is_approved = 1)';
            $results = DB::select($query);

            if (count($results) > 0) {
                foreach ($results as $result) {
                    $lists[] = $result->uid;
                }
            }
        }

        return $lists;
    }
}
