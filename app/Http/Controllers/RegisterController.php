<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin();
            if ($techAdmin) {
                $groups = $roleServ->getRoleDatas();
            } else {
                $groups = $roleServ->getGeneralRoleDatas();
            }
            $groups = $this->authService->getGroupArray($groups);

            return view('auth.register', compact('groups'));
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    protected function validator(array $data)
    {
        $messages = [
            'name.required' => trans('lang.alert_account_internal_name'),
            'name.max' => trans('lang.alert_account_internal_name_length'),
            'username.required' => trans('lang.alert_account_internal_username'),
            'username.max' => trans('lang.alert_account_internal_username_length'),
            'username.unique' => trans('lang.alert_account_internal_username_unique'),
            'email.required' => trans('lang.alert_account_internal_mail'),
            'email.email' => trans('lang.alert_account_internal_mail_format'),
            'email.max' => trans('lang.alert_account_internal_mail_length'),
            'email.unique' => trans('lang.alert_account_internal_mail_unique'),
        ];

        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:50|unique:backend_users',
            'email' => 'required|email|max:255|unique:backend_users',
        ], $messages);
    }

    public function save(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $data = $this->authService->saveUser($request->all());
        $request->session()->flash('alert-success', $data);

        return redirect('register');
    }
}
