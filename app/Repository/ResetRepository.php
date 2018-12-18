<?php

namespace App\Repository;

use App\User;
use Auth;

class ResetRepository
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * 取得帳號資訊.
     *
     * @param int $id id
     *
     * @return obj 帳號資訊
     */
    public function userInfo($id)
    {
        return $this->model->select('name', 'username', 'email', 'password', 'is_lock')->where('id', $id)->first();
    }

    public function reset($request)
    {
        if ($request->resetType == 'other') {
            $id = $request->user;
        } else {
            $id = Auth::user()->id;
        }
        $userData = $this->model->find($id);
        $userData->password = bcrypt($request->password);
        $userData->remember_token = $request->_token;
        $userData->save();
        $message = trans('lang.alert_reset_password_done');

        return $message;
    }
}
