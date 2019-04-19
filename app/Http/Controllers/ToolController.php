<?php

namespace App\Http\Controllers;

//必備
use App\Library\MenuName; //權限
use App\Services\RoleService; //資料庫
use App\Services\ToolService;
//服務
use Carbon\Carbon;
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
    public function banner_edit(Request $request)
    {
        //dd($request);
        if ($this->toolService->banner_edit($request) == true) {
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

    //launcher banner編輯器->顯示
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

    //launcher banner編輯器->新增
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

    //launcher banner編輯器->編輯-入資料
    public function launcher_banner_edit(Request $request)
    {
        //dd($request);
        if ($this->toolService->launcher_banner_edit($request) == true) {
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

    //launcher banner編輯器->刪除
    public function launcher_banner_delete(Request $request)
    {
        if (app('super') === true) {
            $res = $this->toolService->launcher_banner_delete($request->id);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }
    //launcher banner編輯器->排序
    public function launcher_banner_ajax(Request $request)
    {
        $this->toolService->launcher_banner_ajax($request->data);
    }

    //ingame banner編輯器->顯示
    public function ingame_banner(Request $request)
    {

        //有權限
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
            $menuName = new MenuName(); //選單相關
            $method = 'ingame_banner';
            $title = $menuName->getName($method); //取得選單標題
            $data = DB::connection('mysql4')->table('ingame_event_banners')->orderBy('sort')->get();

            //撈資料
            return view('tool.ingame_banner_list', ['title' => $title, 'data' => $data]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    //ingame banner編輯器->新增
    public function ingame_banner_add(Request $request)
    {
        $p = $request->input();
        if ($this->toolService->ingame_banner_add($p) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/ingame/banner';
        echo "<script>
                    alert('$content');
                    window.location ='$to_url';
        </script>";
    }

    //ingame banner編輯器->編輯-入資料
    public function ingame_banner_edit(Request $request)
    {
        //dd($request);
        if ($this->toolService->ingame_banner_edit($request) == true) {
            $content = '已儲存成功';
        } else {
            $content = '儲存失敗';
        }
        $to_url = '/tool/ingame/banner'; //返回頁
        $r = "<script>
                    alert('$content');
                    window.location ='$to_url';
                </script>";

        return $r;
    }

    //ingame banner編輯器->刪除
    public function ingame_banner_delete(Request $request)
    {
        if (app('super') === true) {
            $res = $this->toolService->ingame_banner_delete($request->id);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }
    //ingame banner編輯器->排序
    public function ingame_banner_ajax(Request $request)
    {
        $this->toolService->ingame_banner_ajax($request->data);
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
            $game = $request->game;

            // $data = DB::connection('mysql4')->table('bulletins as b')->selectRaw('b.*, t.short')->leftjoin('bulletin_types as t', 'b.type_id', '=', 't.id')->orderBy('sort')->orderBy('created_at', 'DESC')->get();
            $a_data = $i_data = $a_id_arr = [];

            $active_data = DB::connection('mysql4')->table('bulletins as b')->where('game', $game)->where('start_time', '<=', Carbon::now())->where('end_time', '>=', Carbon::now())->orderBy('sort')->orderBy('created_at', 'DESC')->get();

            foreach ($active_data as $key => $value) {
                $a_data[$value->type_id][] = $value;
                $a_id_arr[] = $value->id;
            }

            $invalid_data = DB::connection('mysql4')->table('bulletins as b')->where('game', $game)->whereNotIn('id', $a_id_arr)->orderBy('sort')->orderBy('created_at', 'DESC')->get();

            foreach ($invalid_data as $key => $value) {
                $i_data[$value->type_id][] = $value;
            }

            $list = DB::connection('mysql4')->table('bulletin_types')->where('game', $game)->get();
            //撈資料
            return view('tool.bulletins_list', ['title' => $title, 'game' => $game, 'a_data' => $a_data, 'i_data' => $i_data, 'list' => $list]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    //公告編輯器->新增
    public function bulletins_add(Request $request)
    {
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'bulletins_add';
        $title = $menuName->getName($method); //取得選單標題
        $game = $request->game;

        $list = DB::connection('mysql4')->table('bulletin_types')->where('game', $game)->get();

        return view('tool.bulletins_add', ['title' => $title, 'game' => $game, 'list' => $list]);

    }

    //公告編輯器->執行新增
    public function do_bulletins_add(Request $request)
    {
        $error = 0;
        $p = $request->input();

        foreach ($p as $key => $v) {

            if ($key == 'content'):
                $p[$key] = str_replace(env('SUB_NAME') . '-b', $request->game, $v);
            endif;

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
            $to_url = '/tool/bulletins/' . $request->game;
            echo "<script>
                alert('$content');
                window.location ='$to_url';
            </script>";
        }
    }

    //公告編輯器->編輯
    public function bulletins_edit(Request $request)
    {
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'bulletins';
        $title = $menuName->getName($method); //取得選單標題
        $game = $request->game;

        $data = DB::connection('mysql4')->table('bulletins')->where('id', $request->id)->first();

        $list = DB::connection('mysql4')->table('bulletin_types')->where('game', $game)->get();

        if ($request->id) {
            return view('tool.bulletins_edit', ['title' => $title, 'game' => $game, 'data' => $data, 'list' => $list]);
        } else {
            echo '缺少參數';
            exit;
        }
    }

    //公告編輯器->執行編輯
    public function do_bulletins_edit(Request $request)
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

                if ($key == 'content'):
                    $p[$key] = str_replace(env('SUB_NAME') . '-b', $request->game, $v);
                endif;

                if (empty($v)) {
                    $error = 1;
                }
            }

            //檢查
            if ($error) {
                $a = '<script> alert("你有欄位空白");
                    </script>';
            } else {
                if ($this->toolService->bulletins_edit($request->id, $p) == true) {
                    $content = '已儲存成功';
                    //return redirect('tool/bulletins');
                } else {
                    $content = '儲存失敗';
                }
                $to_url = '/tool/bulletins/' . $request->game;
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

    /**
     * events編輯器.
     */
    public function events(Request $request)
    {
        //有權限
        if (app('super') === true) {
            $roleServ = new RoleService();
            $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
            $menuName = new MenuName(); //選單相關
            $method = 'events';
            $title = $menuName->getName($method); //取得選單標題
            $game = $request->game;

            $a_data = $a_id_arr = [];

            $active_data = DB::connection('mysql4')->table('event_fb_paintings as p')->where('game', $game)->orderBy('created_at', 'DESC')->get();

            foreach ($active_data as $key => $value) {
                $a_data[$value->type_id][] = $value;
                $a_id_arr[] = $value->id;
            }

            $list = DB::connection('mysql4')->table('event_fb_painting_types')->where('game', $game)->get();
            //撈資料
            return view('tool.events_list', ['title' => $title, 'game' => $game, 'a_data' => $a_data, 'list' => $list]);
        } else {
            // 若無此權限則顯示提醒頁面
            return redirect('error');
        }
    }

    //events編輯器->新增
    public function events_add(Request $request)
    {
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'events_add';
        $title = $menuName->getName($method); //取得選單標題
        $game = $request->game;

        $list = DB::connection('mysql4')->table('event_fb_painting_types')->where('game', $game)->get();

        return view('tool.events_add', ['title' => $title, 'game' => $game, 'list' => $list]);

    }

    //events編輯器->執行新增
    public function do_events_add(Request $request)
    {
        $error = 0;
        $p = $request->input();

        $files = $request->file('file');

        foreach ($p as $key => $v) {

            if ($key == 'content'):

                $content = str_replace(env('SUB_NAME') . '-b', $request->game, $v);

                if ($p['type_id'] == '2'):
                    $content = str_replace(' src=', ' class="r18" src=', $content);
                endif;

                $p[$key] = $content;
            endif;

            if (empty($v)) {
                $error = 1;
            }
        }

        if (is_null($files[0])):
            $a = '<script> alert("請選擇欲上傳之檔案。"); window.history.back(); </script>';
            return $a;
        endif;

        //檢查
        if ($error) {
            $a = '<script> alert("你有欄位空白");
            window.history.back();
            </script>';

            return $a;
        } else {

            foreach ($files as $file):
                if (!is_null($file)):
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $file->getClientOriginalName();
                    $re_file_name = date("YmdHi") . '_' . iconv("UTF-8", "big5", $file_name);

                    $destination_path = public_path() . '/asset/image/event/fan-fiction/190227/';

                    if ($request->hasFile('file')):
                        $res = $file->move($destination_path, $re_file_name);
                    endif;
                endif;

            endforeach;

            $p['game'] = $request->game;
            $p['img'] = '//' . $request->game . '.oasisgames.com.tw/fan-fiction/190227_s/images/list/' . date("YmdHi") . '_' . $file_name;

            if ($this->toolService->events_add($p) == true) {
                $content = '已儲存成功';
                //return redirect('tool/events');
            } else {
                $content = '儲存失敗';
            }
            $to_url = '/tool/events/' . $request->game;
            echo "<script>
                alert('$content');
                window.location ='$to_url';
            </script>";
        }
    }

    //events編輯器->編輯
    public function events_edit(Request $request)
    {
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'events';
        $title = $menuName->getName($method); //取得選單標題
        $game = $request->game;

        $data = DB::connection('mysql4')->table('event_fb_paintings')->where('id', $request->id)->first();

        $list = DB::connection('mysql4')->table('event_fb_painting_types')->where('game', $game)->get();

        if ($request->id) {
            return view('tool.events_edit', ['title' => $title, 'game' => $game, 'data' => $data, 'list' => $list]);
        } else {
            echo '缺少參數';
            exit;
        }
    }

    //公告編輯器->執行編輯
    public function do_events_edit(Request $request)
    {
        $error = 0;
        $roleServ = new RoleService();
        $techAdmin = $roleServ->ifAPAdmin(); //取得$techAdmin
        $menuName = new MenuName(); //選單相關
        $method = 'events';
        $title = $menuName->getName($method); //取得選單標題
        if ($request->q == 'edit') {
            //return "送出修改";
            $p = $request->input();

            $files = $request->file('file');

            foreach ($p as $key => $v) {

                if ($key == 'content'):

                    $content = str_replace(env('SUB_NAME') . '-b', $request->game, $v);

                    if ($p['type_id'] == '2'):
                        $content = str_replace(' src=', ' class="r18" src=', $content);
                    endif;

                    $p[$key] = $content;
                endif;

                if (empty($v)) {
                    $error = 1;
                }
            }

            //檢查
            if ($error) {
                $a = '<script> alert("你有欄位空白");
                    </script>';
            } else {

                $p['game'] = $request->game;

                if (is_null($files[0])):

                    $p['img'] = $p['img_old'];
                else:
                    foreach ($files as $file):
                        if (!is_null($file)):
                            $extension = $file->getClientOriginalExtension();
                            $file_name = $file->getClientOriginalName();
                            $re_file_name = date("YmdHi") . '_' . iconv("UTF-8", "big5", $file_name);

                            $destination_path = public_path() . '/asset/image/event/fan-fiction/190227/';

                            if ($request->hasFile('file')):
                                $res = $file->move($destination_path, $re_file_name);
                            endif;
                        endif;
                    endforeach;

                    $p['img'] = '//' . $request->game . '.oasisgames.com.tw/fan-fiction/190227_s/images/list/' . date("YmdHi") . '_' . $file_name;
                endif;

                if ($this->toolService->events_edit($request->id, $p) == true) {
                    $content = '已儲存成功';
                    //return redirect('tool/events');
                } else {
                    $content = '儲存失敗';
                }
                $to_url = '/tool/events/' . $request->game;
                echo "<script>
                        alert('$content');
                        window.location ='$to_url';
                    </script>";
            }
        }
    }
    //events 編輯器->刪除
    public function events_delete(Request $request)
    {
        if ($this->toolService->events_delete($request->id) == true) {
            return 'ok';
        } else {
            return 'fail';
        }
    }

}
