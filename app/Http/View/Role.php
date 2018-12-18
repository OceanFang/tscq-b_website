<?php

namespace App\Http\View;

use App\User;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;

class Role
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
        if (Auth::check()) {
            $id = $this->auth->user()->id;
            $user_id = User::find($id);
            $role = $user_id->roles()->get();
            $ifTechAdmin = '0';
            foreach ($role as $roleDetail) {
                if ($roleDetail->name == 'tech_administrator') {
                    $ifTechAdmin = '1';
                }
            }
            $view->with(['role' => $role, 'ifTechAdmin' => $ifTechAdmin]);
        } else {
            $view->with(['role' => '', 'ifTechAdmin' => '0']);
        }
    }
}
