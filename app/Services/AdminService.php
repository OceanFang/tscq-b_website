<?php

namespace App\Services;

use App\Repository\AdminRepository;
use App\User;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAdminRole($adminUsers)
    {
        return $this->adminRepository->getdata($adminUsers);
    }

    public function getAjaxRequest($user_id, $user_role)
    {
        return $this->adminRepository->insert_data($user_id, $user_role);
    }

    public function getUserRoles($id)
    {
        $userRoles = [];
        $user = User::where('id', $id)->get();

        foreach ($user as $userData) {
            $username = $userData->username;
            foreach ($userData->roles as $role) {
                $roleId = $role->id;
                $userRoles[] = $roleId;
            }
        }

        $result = [
            'id' => $id,
            'username' => set_default($username),
            'userRoles' => $userRoles,
        ];

        return $result;
    }

    /**
     * 刪除使用者.
     *
     * @param int $id user id
     *
     * @return
     */
    public function delUser($id)
    {
        return $this->adminRepository->delete($id);
    }

    /**
     * 撈取後台人員
     *
     * @param array $techArray AP人員
     *
     * @return array 後台人員
     */
    public function getAdminUsers($techArray)
    {
        return $this->adminRepository->adminUsers($techArray);
    }

    /**
     * 修改使用者.
     *
     * @param int   $id     user id
     * @param array $params 修改參數
     *
     * @return
     */
    public function modifyUser($id, $params)
    {
        return $this->adminRepository->modify($id, $params);
    }
}
