<?php

/* get this you visit menu name */

namespace App\Library;

use App\Menu;
use Config;

class MenuName
{
    public function getName($method = '')
    {
        // 語言
        $lang = Config::get('app.locale');
        if ($lang == 'tw') {
            $columnName = 'name as name';
        } else {
            $columnName = $lang.'_name as name';
        }

        $controller = getCurrentControllerName();
        $method = getCurrentMethodName();
        if ($method != '') {
            $data = Menu::where(['controlName' => $controller, 'methodName' => $method])->select($columnName)->first();
        } else {
            $data = Menu::where('controlName', $controller)->select($columnName)->first();
        }

        return $data;
    }
}
