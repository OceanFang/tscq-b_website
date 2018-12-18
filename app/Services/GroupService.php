<?php

namespace App\Services;

use App\Menu;
use App\Repository\RoleRepository;
use Config;
use Validator;

class GroupService
{
    public function requestValidate($request)
    {
        $result = '';
        $messages = [
            'name.required' => trans('lang.a_name'),
            'permissions.required' => trans('lang.a_permission'),
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permissions' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->first();
        }

        return $result;
    }

    /**
     * 撈出的權限資料分層.
     *
     * @param array $groups
     *
     * @return array
     */
    public function getMenuTree()
    {
        // 模組名稱
        $modules = [];
        // 功能名稱
        $mainMenu = [];
        // 子功能
        $subMenu = [];

        // 語言
        $lang = Config::get('app.locale');
        if ($lang == 'tw') {
            $columnName = 'name';
        } else {
            $columnName = $lang.'_name';
        }

        $menus = Menu::orderBy('order', 'asc')->get();
        foreach ($menus as $menu) {
            $parent_id = $menu->parent_id;
            $is_sub = $menu->is_sub;
            $id = $menu->id;
            $name = $menu->$columnName;
            switch ($parent_id) {
                case 0:
                    $modules[] = ['id' => $id, 'name' => $name];
                    break;

                default:
                    if ($is_sub == 1) {
                        $subMenu[$parent_id][] = ['id' => $id, 'name' => $name];
                    } else {
                        $mainMenu[$parent_id][] = ['id' => $id, 'name' => $name];
                    }
                    break;
            }
        }

        $result = [
            'modules' => $modules,
            'mainMenu' => $mainMenu,
            'subMenu' => $subMenu,
        ];

        return $result;
    }

    public function getGroupPermissions($id)
    {
        $groupPermissions = [];
        $roleRepo = new RoleRepository();
        $role = $roleRepo->roleData($id);
        foreach ($role as $rolelist) {
            $name = $rolelist->name;
            foreach ($rolelist->menus as $permission) {
                $permission_id = $permission->id;
                $groupPermissions[] = $permission_id;
            }
        }
        $result = [
            'id' => $id,
            'name' => set_default($name),
            'groupPermissions' => $groupPermissions,
        ];

        return $result;
    }

    /**
     * 刪除群組.
     *
     * @param int $id 群組id
     *
     * @return
     */
    public function destroyGroup($id)
    {
        $roleRepo = new RoleRepository();

        return $roleRepo->delete($id);
    }

    /**
     * 建立群組.
     *
     * @param array  $permissions 權限
     * @param string $name        名稱
     *
     * @return
     */
    public function createGroup($permissions, $name)
    {
        $roleRepo = new RoleRepository();
        $roleRepo->create($permissions, $name);
    }

    /**
     * 修改群組.
     *
     * @param int    $id          群組id
     * @param array  $permissions 權限
     * @param string $name        名稱
     *
     * @return
     */
    public function modifyGroup($id, $permissions, $name)
    {
        $roleRepo = new RoleRepository();
        $roleRepo->modify($id, $permissions, $name);
    }
}
