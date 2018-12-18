<?php

namespace App\Repository;

use App\Library\Accessibility;
use App\Library\RandomPassword;
use App\User;
use App\Role;

class AuthRepository
{
    protected $random;
    protected $sendEmail;

    public function __construct(RandomPassword $random, Accessibility $sendEmail)
    {
        $this->random = $random;
        $this->sendEmail = $sendEmail;
    }

    /**
     * 創建後台使用者帳號
     *
     * @param array $data 記錄資訊
     *
     * @return
     */
    public function createUser($data)
    {
        $password = $this->random->generateStrongPassword();

        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($password);
        $user->save();
        $insertId = $user->id;
        $update = User::find($insertId);
        $update->roles()->attach($data['position']);
        $update->save();

        $role = Role::select('name')->where('id', $data['position'])->first();
        if ($role === null) {
            $roleName = '';
        } else {
            $roleName = $role->name;
        }

        $alertName = trans('lang.mail_create_success').'!<br>'.trans('lang.mail_confirm_username').$roleName.trans('lang.mail_confirm_username2').$data['username'].'<br><a href="/">'.trans('lang.backhome').'</a>';
        //寄送email
        $emailData = [
            'blade' => 'emails.welcome',
            'email' => $data['email'],
            'username' => trans('lang.mail_content_username').$data['username'],
            'password' => trans('lang.mail_content_password').$password,
            'subject' => trans('lang.mail_title2'),
            'title' => trans('lang.mail_create_success'),
        ];
        $this->sendEmail->email($emailData);

        return $alertName;
    }
}
