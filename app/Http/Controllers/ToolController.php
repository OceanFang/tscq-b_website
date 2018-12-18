<?php

namespace App\Http\Controllers;

//必備
use App\Library\MenuName; //權限
use App\Services\RoleService; //資料庫
use App\Services\ToolService;
//服務
use DB; //跟權限檢查有關
use Illuminate\Http\Request; //接收參數必須
use Illuminate\Support\Facades\Redirect;

class ToolController extends Controller
{
    protected $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    //banner編輯器->顯示
    public function banner(Request $request)
    {

        //有權限
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
            $menuName = new MenuName(); //選單相關
            $method = 'banner';
            $title = $menuName->getName($method); //取得選單標題
            $data = DB::connection('mysql4')->table('banners')->orderBy('sort')->get();

            //撈資料
            return view('tool.banner_list', ['title' => $title, 'data' => $data]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }
    //banner編輯器->新增
    public function banner_add(Request $request)
    {
        $p = $request->input();
        if ($this->toolService->banner_add($p) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/banner';
        echo "<script>
                    alert('$content');
                    window.location ='$to_url';
        </script>";
    }

    //banner編輯器->編輯-入資料
    public function banner_editok(Request $request)
    {
        //dd($request);
        if ($this->toolService->banner_editok($request) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/banner'; //返回頁
        $r = "<script>
                    alert('$content');
                    window.location ='$to_url';
                </script>";

        return $r;
    }

    //banner編輯器->刪除
    public function banner_delete(Request $request)
    {
        if (app('super') === true) {
            $res = $this->toolService->banner_delete($request->id);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }
    //banner編輯器->排序
    public function banner_ajax(Request $request)
    {
        $this->toolService->banner_ajax($request->data);
    }

    //banner編輯器->顯示
    public function launcher_banner(Request $request)
    {

        //有權限
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
            $menuName = new MenuName(); //選單相關
            $method = 'launcher_banner';
            $title = $menuName->getName($method); //取得選單標題
            $data = DB::connection('mysql4')->table('launcher_banners')->orderBy('sort')->get();

            //撈資料
            return view('tool.launcher_banner_list', ['title' => $title, 'data' => $data]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }
    //banner編輯器->新增
    public function launcher_banner_add(Request $request)
    {
        $p = $request->input();
        if ($this->toolService->launcher_banner_add($p) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/launcher/banner';
        echo "<script>
                    alert('$content');
                    window.location ='$to_url';
        </script>";
    }

    //banner編輯器->編輯-入資料
    public function launcher_banner_editok(Request $request)
    {
        //dd($request);
        if ($this->toolService->launcher_banner_editok($request) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/launcher/banner'; //返回頁
        $r = "<script>
                    alert('$content');
                    window.location ='$to_url';
                </script>";

        return $r;
    }

    //banner編輯器->刪除
    public function launcher_banner_delete(Request $request)
    {
        if (app('super') === true) {
            $res = $this->toolService->launcher_banner_delete($request->id);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }
    //banner編輯器->排序
    public function launcher_banner_ajax(Request $request)
    {
        $this->toolService->launcher_banner_ajax($request->data);
    }

    /**
     * 公告編輯器.
     */
    public function bulletins(Request $request)
    {
        //有權限
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
            $menuName = new MenuName(); //選單相關
            $method = 'bulletins';
            $title = $menuName->getName($method); //取得選單標題
            $data = DB::connection('mysql4')->table('bulletins as b')->selectRaw('b.*, t.short')->leftjoin('bulletin_types as t', 'b.type_id', '=', 't.id')->orderBy('sort')->orderBy('created_at', 'DESC')->get();
            // dd($data);
            $list = DB::connection('mysql4')->table('bulletin_types')->get();
            //撈資料
            return view('tool.bulletins_list', ['title' => $title, 'data' => $data, 'list' => $list]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    //公告編輯器->新增
    public function bulletins_add(Request $request)
    {
        $error = 0;
        $p = $request->input();

        foreach ($p as $key => $v) {
            if (empty($v)) {
                $error = 1;
            }
        }
        //檢查
        if ($error) {
            $a = '<script> alert("你有欄位空白");
            window.history.back();
            </script>';

            return $a;
        } else {
            if ($this->toolService->bulletins_add($p) == true) {
                $content = '已儲存成功';
                //return redirect('tool/bulletins');
            } else {
                $content = '儲存失敗';
            }
            $to_url = '/tool/bulletins';
            echo "<script>
                alert('$content');
                window.location ='$to_url';
            </script>";
        }
    }

    //公告編輯器->編輯
    public function bulletins_editok(Request $request)
    {
        $error = 0;
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'bulletins';
        $title = $menuName->getName($method); //取得選單標題
        if ($request->q == 'edit') {
            //return "送出修改";
            $p = $request->input();
            foreach ($p as $key => $v) {
                if (empty($v)) {
                    $error = 1;
                }
            }
            //檢查
            if ($error) {
                $a = '<script> alert("你有欄位空白");
                    </script>';
            } else {
                if ($this->toolService->bulletins_editok($request->id, $p) == true) {
                    $content = '已儲存成功';
                    //return redirect('tool/bulletins');
                } else {
                    $content = '儲存失敗';
                }
                $to_url = '/tool/bulletins';
                echo "<script>
                        alert('$content');
                        window.location ='$to_url';
                    </script>";
            }
        }
    }
    //公告編輯器->刪除
    public function bulletins_delete(Request $request)
    {
        if ($this->toolService->bulletins_delete($request->id) == true) {
            return 'ok';
        } else {
            return 'fail';
        }
    }
    //公告編輯器->排序
    public function bulletins_ajax(Request $request)
    {
        $this->toolService->bulletins_ajax($request->data);
    }

}
