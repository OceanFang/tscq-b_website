<?php

namespace App\Http\Controllers;

use App\Library\MenuName;
use App\Services\GroupService;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index(Request $request)
    {
        if (app('super') === true) {
            $menuName = new MenuName();
            $title = $menuName->getName();
            $request->session()->put('prev_url', $request->url());

            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin();
            if ($techAdmin) {
                $groups = $roleServ->getRoleDatas();
            } else {
                $groups = $roleServ->getGeneralRoleDatas();
            }

            return view('group.list', ['groups' => $groups, 'title' => $title]);
        } else {
            //若無此權限則進入錯誤提醒頁面
            return redirect('error');
        }
    }

    public function manage(Request $request)
    {
        $menuTree = $this->groupService->getMenuTree();
        $id = $request->input('id');
        $groupPermissions = $this->groupService->getGroupPermissions($id);

        return view('group.modify', ['groupPermissions' => $groupPermissions, 'menuTree' => $menuTree]);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $name = $request->name;
        $status = trans('lang.completed');
        $message = '';
        try {
            $requestValidateMsg = $this->groupService->requestValidate($request);
            if ($requestValidateMsg != '') {
                throw new Exception($requestValidateMsg);
            }

            if ($id == '') {
                $this->groupService->createGroup($request->permissions, $name);
            } else {
                $this->groupService->modifyGroup($id, $request->permissions, $name);
            }
        } catch (Exception $e) {
            $status = 'fail';
            $message = $e->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }

    public function destroy(Request $request)
    {
        $delStatus = $this->groupService->destroyGroup($request->id);

        if ($delStatus == true) {
            return 'ok';
        } else {
            return 'fail';
        }
    }
}
