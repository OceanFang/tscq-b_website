<?php

namespace App\Http\Controllers;

use Auth;
use App\Library\MenuName;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * 管理員列表顯示清單.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin();

            $menuName = new MenuName();
            $title = $menuName->getName();
            $request->session()->put('prev_url', $request->url());

            if ($techAdmin) {
                $adminUsers = [];
                $roles = $roleServ->getRoleDatas();
            } else {
                $adminUsers = $roleServ->getAdminId();
                $roles = $roleServ->getGeneralRoleDatas();
                $selectUser = $this->adminService->getAdminUsers($adminUsers);
            }
            $selectUser = $this->adminService->getAdminUsers([]);

            $id = Auth::user()->id;
            $users = $this->adminService->getAdminRole($adminUsers);
            $userRole = $this->adminService->getUserRoles($id);

            return view('admin.list', ['users' => $users, 'selectUser' => $selectUser, 'user_role' => $userRole, 'roles' => $roles, 'title' => $title]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    /**
     * 設定人員群組.
     *
     * @param Request $request
     */
    public function manage(Request $request)
    {
        $userId = $request->admin_id;
        $userRole = $request->userRoles;
        $this->adminService->getAjaxRequest($userId, $userRole);
    }

    public function del(Request $request)
    {
        if ($this->adminService->delUser($request->id) == true) {
            return 'ok';
        } else {
            return 'fail';
        }
    }

    public function lockStatusModify(Request $request)
    {
        $params = [
             'is_lock' => $request->lock,
        ];
        if ($this->adminService->modifyUser($request->id, $params) == true) {
            return 'ok';
        } else {
            return 'fail';
        }
    }
}
