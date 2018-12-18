<?php

namespace App\Repository;

use App\User;
use App\Role;
use App\RoleUser;
use Auth;
use Carbon\Carbon;

class RoleRepository extends CoreRepository
{
    public function __construct()
    {
        //
    }

    public function roleInfo()
    {
        $id = Auth::user()->id;
        $member = User::find($id)->roles;

        return $member;
    }

    public function allAdmin()
    {
        $id = Role::where('name', 'tech_administrator')->lists('id');

        $adminUsers = RoleUser::where('role_id', $id)->lists('backend_user_id');

        return $adminUsers;
    }

    public function roleDatas()
    {
        $roles = Role::all();

        return $roles;
    }

    public function generalRoleDatas()
    {
        $roles = Role::where('name', '<>', 'tech_administrator')->get();

        return $roles;
    }

    public function roleData($id)
    {
        $roleData = Role::where('id', $id)->get();

        return $roleData;
    }

    /**
     * 刪除群組.
     *
     * @param int $id 群組id
     *
     * @return
     */
    public function delete($id)
    {
        $role = Role::find($id);
        $menuDetach = $role->menus()->detach();

        return $delAction = $role->delete();
    }

    /**
     * 建立群組.
     *
     * @param array  $permissions 權限
     * @param string $name        名稱
     *
     * @return
     */
    public function create($permissions, $name)
    {
        $group = new Role();
        $group->name = $name;
        $group->save();
        $groupId = $group->id;

        $group = Role::find($groupId);
        $group->menus()->sync($permissions);
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
    public function modify($id, $permissions, $name)
    {
        $group = Role::find($id);
        $group->menus()->sync($permissions);
        $group->name = $name;
        $group->updated_at = Carbon::now();
        $group->save();
    }
}
