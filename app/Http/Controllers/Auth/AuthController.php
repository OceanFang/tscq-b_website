<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $username = 'username';
    protected $redirectTo = 'register';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin_users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        //判断是否限制登录次数
        $throttles = $this->isUsingThrottlesLoginsTrait();
        // 是否超标
        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request); //触发锁定登录，一分钟。

            return $this->sendLockoutResponse($request);
        }

        // 密码验证
        $credentials = $this->getCredentials($request); //调用getCredentials验证
        // 验证通过，冻结验证
        $checkLock = User::where('username', $credentials['username'])->where('is_lock', 0)->count();
        if ($checkLock != 0) {
            if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {

                //验证通過
                return $this->handleUserWasAuthenticated($request, $throttles);
            } else {
                // 验证失败，增加失败记录
                if ($throttles && !$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                return $this->sendFailedLoginResponse($request);
            }
        } else {
            // 验证失败，增加失败记录
            if ($throttles && !$lockedOut) {
                $this->incrementLoginAttempts($request);
            }

            return $this->sendFailedLoginResponse($request, 1);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request, $type = 0)
    {
        if ($type == 0) {
            return redirect()->back()
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
        } else {
            return redirect()->back()
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessageLock(),
                ]);
        }
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return trans('lang.login_faild');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessageLock()
    {
        return trans('lang.login_lock');
    }

    /**
     * @param Request $request [description]
     *
     * @return [type] [description]
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => trans('validation.captcha'),
            'captcha.required' => trans('validation.captcha_required'),
        ]
        );
    }
}
