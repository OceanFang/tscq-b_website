<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Services\ResetService;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     */
    public function __construct(ResetService $resetService)
    {
        $this->resetService = $resetService;
    }

    public function index(Request $request)
    {
        if (app('super') === true) {
            $id = $request->id;
            $info = $this->resetService->getUserInfo($id);

            return view('auth.passwords.reset', ['id' => $id, 'info' => $info, 'resetType' => 'other', 'formType' => 'form_back_to_main']);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    public function ownReset()
    {
        $id = Auth::user()->id;
        $info = $this->resetService->getUserInfo($id);

        return view('auth.passwords.reset', ['id' => $id, 'info' => $info, 'resetType' => 'own', 'formType' => 'modify_form']);
    }

    public function reseting(Request $request)
    {
        $status = 'ok';
        $message = '';
        try {
            $requestValidateMsg = $this->resetService->requestValidate($request);
            if ($requestValidateMsg != '') {
                throw new Exception($requestValidateMsg);
            }

            $data = $this->resetService->resetPassword($request);
        } catch (Exception $e) {
            $status = 'fail';
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message', 'data'));
    }
}
