<?php

if (!function_exists('set_default')) {
    function set_default(&$name, $default = '')
    {
        if (isset($name)) {
            return $name;
        }

        return $default;
    }
}

//取得controller name
if (!function_exists('getCurrentControllerName')) {
    function getCurrentControllerName()
    {
        return getCurrentAction()[0];
    }
}

//取得method name
if (!function_exists('getCurrentMethodName')) {
    function getCurrentMethodName()
    {
        return getCurrentAction()[1];
    }
}

if (!function_exists('getCurrentAction')) {
    function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        if ($action == 'Closure') {
            list($class, $method) = ['', ''];
        } else {
            $action = str_replace('App\Http\Controllers\\', '', $action);
            list($class, $method) = explode('@', $action);
        }

        return [$class, $method];
    }
}

if (!function_exists('master')) {
    function master($datas = [])
    {
        return app('super', $datas);
    }
}

if (!function_exists('getPrevUurl')) {
    function getPrevUurl($request)
    {
        $prev_url = $request->url();
        $parameters = '';
        foreach ($request->query() as $key => $value) {
            if (strlen($value) > 0) {
                if ($parameters == '') {
                    $parameters .= '?'.$key.'='.$value;
                } else {
                    $parameters .= '&'.$key.'='.$value;
                }
            }
        }

        return $prev_url.$parameters;
    }
}

if (!function_exists('trimz')) {
    function trimz($value)
    {
        $value = explode('.', $value);
        if (count($value) == 2 && ($value[1] = rtrim($value[1], '0'))) {
            return implode('.', $value);
        }

        return $value[0];
    }
}

if (!function_exists('betDisplayValue')) {
    function betDisplayValue($value)
    {
        $result = ($value / 1000);

        return $result;
    }
}

if (!function_exists('betDisplayFormat')) {
    function betDisplayFormat($value)
    {
        $value = ($value / 1000);
        $result = trimz(number_format($value, 3));

        return $result;
    }
}

if (!function_exists('diffArray')) {
    /**
     * 比較陣列，返回差集.
     *
     * @param array $array_1
     * @param array $array_2
     *
     * @return array
     */
    function diffArray($array_1, $array_2)
    {
        $array_2 = array_flip($array_2);
        foreach ($array_1 as $key => $item) {
            if (isset($array_2[$item])) {
                unset($array_1[$key]);
            }
        }

        return $array_1;
    }
}

if (!function_exists('showWeekday')) {
    function showWeekday($date)
    {
        $week = array('日', '一', '二', '三', '四', '五', '六');

        list($y, $m, $d) = explode('-', $date); //分離出年月日以便製作時戳
        return $date.'  ('.$week[date('w', mktime(0, 0, 0, $m, $d, $y))].')';
    }
}

if (!function_exists('exchangeID')) {
    function exchangeID($id)
    {
        $tmpId = 0;
        for ($i = 0; $i < 31; ++$i) {
            $tmpId += (($id >> $i) % 2) << (30 - $i);
        }

        return $tmpId;
    }
}

/*
 * 初始化日期變數，給予預設值
 *
 * @param obj    $request 參數
 * @param string $type    day/week/month
 *
 * @return obj $request
 */
if (!function_exists('requestDateInit')) {
    function requestDateInit($request, $type = 'day')
    {
        $carbon = new \Carbon\Carbon();
        switch ($type) {
            case 'week':
                $request->start_date = ($request->start_date === null) ? $carbon->now()->startOfWeek()->toDateString() : $request->start_date;
                $request->end_date = ($request->end_date === null) ? $carbon->now()->ToDateString() : $request->end_date;
                break;
            case 'month':
                $request->start_date = ($request->start_date === null) ? $carbon->now()->startOfMonth()->toDateString() : $request->start_date;
                $request->end_date = ($request->end_date === null) ? $carbon->now()->ToDateString() : $request->end_date;
                break;
            case 'monthNotIncludeToday':
                $request->start_date = ($request->start_date === null) ? $carbon->now()->subDay()->startOfMonth()->toDateString() : $request->start_date;
                $request->end_date = ($request->end_date === null) ? $carbon->now()->subDay()->ToDateString() : $request->end_date;
                break;
            default:
                $request->start_date = ($request->start_date === null) ? $carbon->now()->startOfDay()->toDateString() : $request->start_date;
                $request->end_date = ($request->end_date === null) ? $carbon->now()->ToDateString() : $request->end_date;
                break;
        }

        return $request;
    }
}

if (!function_exists('sortBtn')) {
    function sortBtn($request, $column)
    {
        $url = $request->fullUrl();
        $url = str_replace('&zsort_by=&zsort_type=', '', $url);
        $sortBy = $request->zsort_by;
        $sort = $request->zsort_type;
        $style = 'color:white';
        // 已有排序
        if (!is_null($sortBy) && !is_null($sort) && trim($sortBy) != '' && trim($sort) != '') {
            // 是否為同一個欄位改變排序
            if ($sortBy == $column) {
                switch ($sort) {
                    case 'asc':
                        $href = str_replace('asc', 'desc', $url);
                        $sort = 'asc';
                        break;
                    default:
                        // desc時恢復未排序狀態
                        if (strpos($url, '?zsort_by') === false) {
                            $href = explode('&zsort_by', $url)[0];
                        } else {
                            $href = explode('?zsort_by', $url)[0];
                        }
                        $sort = 'desc';
                        break;
                }
            } else {
                if (strpos($url, '?zsort_by') === false) {
                    $href = explode('&zsort_by', $url)[0].'&zsort_by='.$column.'&zsort_type=asc';
                } else {
                    $href = explode('?zsort_by', $url)[0].'?zsort_by='.$column.'&zsort_type=asc';
                }
                $sort = 'asc';
                $style = 'color:gray';
            }
        } else {
            // 無排序
            $sort = 'asc';
            $style = 'color:gray';
            if (strpos($url, '?') === false) {
                $href = $url.'?zsort_by='.$column.'&zsort_type=asc';
            } else {
                $href = $url.'&zsort_by='.$column.'&zsort_type=asc';
            }
        }

        $btn = '<a href="'.$href.'"><i style="float: right;'.$style.'" class="fa fa-sort-amount-'.$sort.'"></i></a>';

        return $btn;
    }
}
