<?php

namespace App\Services;

use App\Repository\RoleRepository;

class RoleService
{
    /**
     * 確認使用者有哪些身份.
     *
     * @return array
     */
    public function getRoleInfo()
    {
        $userRoles = [];

        $roleRepo = new RoleRepository();
        $roles = $roleRepo->roleInfo();
        foreach ($roles as $role) {
            $userRoles[] = $role->name;
        }

        return $userRoles;
    }

    /**
     * 確認使用者有哪些身份.
     *
     * @return array
     */
    public function ifAPAdmin()
    {
        $userRoles = $this->getRoleInfo();

        return in_array('tech_administrator', $userRoles);
    }

    /**
     * 取得最高權限群組中的user id.
     *
     * @return array
     */
    public function getAdminId()
    {
        $roleRepo = new RoleRepository();
        $adminUsers = $roleRepo->allAdmin();

        return $adminUsers;
    }

    /**
     * 取得role data.
     *
     * @return array
     */
    public function getRoleDatas()
    {
        $roleRepo = new RoleRepository();
        $datas = $roleRepo->roleDatas();

        return $datas;
    }

    /**
     * 取得tech_administrator以外的role data.
     *
     * @return array
     */
    public function getGeneralRoleDatas()
    {
        $roleRepo = new RoleRepository();
        $datas = $roleRepo->generalRoleDatas();

        return $datas;
    }
}
