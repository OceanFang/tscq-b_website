<?php

namespace App\Http\View;

use App\Menu as MenuModel;
use App\User;
use Config;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;

class Menu
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * 將資料綁定到視圖。
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        // 取得遊戲控制區域的id
        $controlArea = MenuModel::where(['name' => '遊戲控制'])->first();
        $controlAreaId = ($controlArea === null) ? 7 : $controlArea->id;

        // 取得目前路徑判斷須展開mune區域
        $currentMenuIds = [];
        $controllerName = getCurrentControllerName();
        $methodName = getCurrentMethodName();
        if (!in_array($controllerName, ['HomeController', ''])) {
            $whileStop = 'no';
            // 有在menu table中的同時判斷controllerName與methodName
            $currentMenuData = MenuModel::where(['controlName' => $controllerName, 'methodName' => $methodName])->first();

            if (!is_null($currentMenuData)) {
                array_push($currentMenuIds, $currentMenuData->id);
                $currentMenuParentId = $currentMenuData->parent_id;
                if ($currentMenuParentId > 0) {
                    while ($whileStop == 'no') {
                        $parentMenuData = MenuModel::where('id', $currentMenuParentId)->first();
                        if (!is_null($parentMenuData) > 0) {
                            array_push($currentMenuIds, $parentMenuData->id);
                            if ($parentMenuData->parent_id > 0) {
                                $currentMenuParentId = $parentMenuData->parent_id;
                            } else {
                                $whileStop = 'yes';
                            }
                        } else {
                            $whileStop = 'yes';
                        }
                    }
                }
            } else {
                // 不在menu table中的子功能則只抓取controllerName(不同分區之功能盡量勿使用同一controller)
                $currentMenuData = MenuModel::where(['controlName' => $controllerName])->first();
                if (!is_null($currentMenuData) > 0) {
                    array_push($currentMenuIds, $currentMenuData->id);
                    $currentMenuParentId = $currentMenuData->parent_id;
                    if ($currentMenuParentId > 0) {
                        while ($whileStop == 'no') {
                            $parentMenuData = MenuModel::where('id', $currentMenuParentId)->first();
                            if (!is_null($parentMenuData) > 0) {
                                array_push($currentMenuIds, $parentMenuData->id);
                                if ($parentMenuData->parent_id > 0) {
                                    $currentMenuParentId = $parentMenuData->parent_id;
                                } else {
                                    $whileStop = 'yes';
                                }
                            } else {
                                $whileStop = 'yes';
                            }
                        }
                    }
                }
            }
        }

        // 語言
        $lang = Config::get('app.locale');
        if ($lang == 'tw') {
            $columnName = 'name';
        } else {
            $columnName = $lang . '_name';
        }

        // 權限可見menu
        $id = $this->auth->user()->id;
        $member = User::find($id);
        $mainMenuArray = [];
        $subMenuArray = [];
        $thirdMenuArray = [];
        $expectId = [];
        $menuList = [];

        // 推廣員資格審核ID
        $agentFunction = MenuModel::where(['name' => '推廣員資格審核'])->first();
        $agentFunctionId = ($agentFunction === null) ? 76 : $agentFunction->id;
        array_push($expectId, $agentFunctionId);

        // 一般後台帳號
        foreach ($member->roles as $group) {
            foreach ($group->menus->where('parent_id', $controlAreaId) as $value) {
                array_push($expectId, $value->id);
            }

            // get role menu permissions
            foreach ($group->menus->where('is_show', 1) as $menu) {
                array_push($menuList, $menu->id);
            }

            // get main menu
            $mainMenus = MenuModel::whereIn('id', $menuList)->where(['is_show' => 1, 'parent_id' => 0])->orderBy('order', 'ASC')->get();
            foreach ($mainMenus as $main) {
                $mainMenuArray[$main->id] = [
                    'id' => $main->id,
                    'name' => $main->$columnName,
                    'icon' => $main->icon,
                ];

                // get sub menu
                $subMenus = MenuModel::whereIn('id', $menuList)->where('is_show', 1)->where('parent_id', $main->id)->orderBy('order', 'ASC')->get();
                foreach ($subMenus as $sub) {
                    $subMenuArray[$main->id][$sub->id] = [
                        'id' => $sub->id,
                        'name' => $sub->$columnName,
                        'method_name' => ($sub->methodName == 'index') ? '' : $sub->methodName,
                        'route_name' => $sub->routeName,
                    ];

                    // get third menu
                    $thirdMenus = MenuModel::whereIn('id', $menuList)->where('is_show', 1)->where('parent_id', $sub->id)->orderBy('order', 'ASC')->get();

                    foreach ($thirdMenus as $third) {
                        $thirdMenuArray[$sub->id][$third->id] = [
                            'id' => $third->id,
                            'name' => $third->$columnName,
                            'method_name' => ($third->methodName == 'index') ? '' : $third->methodName,
                            'route_name' => $third->routeName,
                        ];
                    }
                }
            }
        }

        $view->with(['mainMenuArray' => $mainMenuArray, 'subMenuArray' => $subMenuArray, 'thirdMenuArray' => $thirdMenuArray, 'expectId' => $expectId]);
    }
}
