<?php

namespace App\Services;

use App\Repository\ResetRepository;
use Validator;

class ResetService
{
    protected $resetRepo;
    public function __construct(ResetRepository $resetRepo)
    {
        $this->resetRepo = $resetRepo;
    }

    public function getUserInfo($id)
    {
        return $this->resetRepo->userInfo($id);
    }

    public function requestValidate($request)
    {
        $result = '';
        $messages = [
            // 'oldpassword.required' => trans('lang.alert_old_password'),
            'password.required' => trans('lang.alert_new_password'),
            'password_confirm.required' => trans('lang.alert_confirm_password'),
            'between' => trans('lang.alert_password_length'),
            'password_confirm.same' => trans('lang.alert_wrong_confirm_password'),
        ];
        $validator = Validator::make($request->all(), [
            // 'oldpassword' => 'required|between:6,20',
            'password' => 'required|between:6,20',
            'password_confirm' => 'required|same:password',
        ], $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->first();
        }

        return $result;
    }

    public function resetPassword($request)
    {
        return $this->resetRepo->reset($request);
    }
}
