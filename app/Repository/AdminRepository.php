<?php

namespace App\Repository;

use App\User;

class AdminRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getdata($adminUsers)
    {
        if (count($adminUsers) > 0) {
            $users = $this->model->whereNotIn('id', $adminUsers)->paginate(30);
        } else {
            $users = $this->model->paginate(30);
        }

        return $users;
    }

    public function insert_data($user_id, $user_role)
    {
        //新增user到role_user table
        $user = $this->model->find($user_id);
        $user->roles()->sync($user_role);
    }

    /**
     * 撈取後台人員
     *
     * @param array $techArray AP人員
     *
     * @return array 後台人員
     */
    public function adminUsers($techArray)
    {
        if (count($techArray) > 0) {
            return User::whereNotIn('id', $techArray)->lists('username', 'id');
        } else {
            return User::lists('username', 'id');
        }
    }

    /**
     * 刪除使用者.
     *
     * @param int $id user id
     *
     * @return
     */
    public function delete($id)
    {
        $user = User::find($id);

        // 1. del user_role
        $role = $user->roles()->detach();

        // 2. del user data
        $del = $user->delete();

        return $del;
    }

    /**
     * 修改使用者.
     *
     * @param int   $id     user id
     * @param array $params 修改參數
     *
     * @return
     */
    public function modify($id, $params)
    {
        return User::where('id', $id)->update($params);
    }
}
