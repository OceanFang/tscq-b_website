<?php

namespace App\Repository;

use App\Banner; //banner
use App\Bulletin; //launcher banner
use App\LauncherBanner; //公告
use DB;

//跑馬燈
//跑馬燈
//載入資料表控制

class ToolRepository extends CoreRepository
{
    public function __construct()
    {
    }

    //banner編輯器->新增
    public function banner_add($request)
    {
        $obj = new Banner();
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->description = $request['description'];
        $obj->img = $request['img'];
        $obj->url = $request['url'];
        //先查
        $sort = Banner::orderBy('sort', 'desc')->value('sort'); //取得1個值
        $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }
    //banner編輯器->編輯
    public function banner_editok($request)
    {
        $obj = Banner::find($request->id);
        $obj->start_time = $request->start_time;
        $obj->end_time = $request->end_time;
        $obj->description = $request->description;
        $obj->img = $request->img;
        $obj->url = $request->url;
        $r = $obj->save();

        return $r;
    }
    //banner編輯器->刪除
    public function banner_delete($id)
    {
        $user_obj = Banner::find($id);
        $del = $user_obj->delete();

        return $del;
    }
    //banner燈編輯器->排序
    public function banner_ajax($data)
    {
        foreach ($data as $key => $value) {
            Banner::where('id', $value)->update(['sort' => $key]); // 更新所有資料排序
        }
    }

    //launcher banner編輯器->新增
    public function launcher_banner_add($request)
    {
        $obj = new LauncherBanner();
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->description = $request['description'];
        $obj->img = $request['img'];
        $obj->url = $request['url'];
        //先查
        $sort = LauncherBanner::orderBy('sort', 'desc')->value('sort'); //取得1個值
        $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }
    //launcher banner編輯器->編輯
    public function launcher_banner_editok($request)
    {
        $obj = LauncherBanner::find($request->id);
        $obj->start_time = $request->start_time;
        $obj->end_time = $request->end_time;
        $obj->description = $request->description;
        $obj->img = $request->img;
        $obj->url = $request->url;
        $r = $obj->save();

        return $r;
    }
    //launcher banner編輯器->刪除
    public function launcher_banner_delete($id)
    {
        $user_obj = LauncherBanner::find($id);
        $del = $user_obj->delete();

        return $del;
    }
    //launcher banner燈編輯器->排序
    public function launcher_banner_ajax($data)
    {
        foreach ($data as $key => $value) {
            LauncherBanner::where('id', $value)->update(['sort' => $key]); // 更新所有資料排序
        }
    }

    /**
     * 跑馬燈->編輯+新增.
     */
    public function marquee_edit($id, $content)
    {
        if (empty($id)) {

            //要有內容才新增
            if (!empty($content)) {
                //先查
                $order = Marquee::orderBy('order', 'desc')->value('order'); //取得1欄
                $obj = new Marquee();
                $obj->content = $content;
                $obj->order = $order + 1;
                $r = $obj->save();

                return $r;
            } else {
                return 0;
            }
        } else {
            $obj = Marquee::find($id);
            $obj->content = $content;
            $r = $obj->save();

            return $r;
        }
    }

    /**
     * 跑馬燈->刪除.
     */
    public function marquee_delete($id)
    {
        $user_obj = Marquee::find($id);
        $del = $user_obj->delete();

        return $del;
    }
    //跑馬燈編輯器->排序
    public function marquee_ajax($data)
    {
        foreach ($data as $key => $value) {
            Marquee::where('id', $value)->update(['order' => $key]); // 更新所有資料排序
        }
    }

    //公告編輯器->新增
    public function bulletins_add($request)
    {

        $obj = new Bulletin();
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->type_id = $request['type_id'];
        $obj->title = $request['title'];
        $obj->content = $request['content'];
        //先查
        $sort = Bulletin::orderBy('sort', 'desc')->value('sort'); //取得1個值
        $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }
    //公告編輯器->編輯
    public function bulletins_editok($id, $request)
    {
        $obj = Bulletin::find($id);
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->type_id = $request['type_id'];
        $obj->title = $request['title'];
        $obj->content = $request['content'];
        $r = $obj->save();

        return $r;
    }
    //公告編輯器->刪除
    public function bulletins_delete($id)
    {
        $user_obj = Bulletin::find($id);
        $del = $user_obj->delete();

        return $del;
    }
    //跑馬燈編輯器->排序
    public function bulletins_ajax($data)
    {
        dump($data);
        foreach ($data as $key => $value) {
            Bulletin::where('id', $value)->update(['sort' => $key]); // 更新所有資料排序
        }
    }

    /**
     * 建立群組.
     *
     * @param array  $permissions 權限
     * @param string $name        名稱
     *
     * @return
     */
    public function create($permissions, $name)
    {
        $group = new Role();
        $group->name = $name;
        $group->save();
        $groupId = $group->id;

        $group = Role::find($groupId);
        $group->menus()->sync($permissions);
    }

    /**
     * 修改群組.
     *
     * @param int    $id          群組id
     * @param array  $permissions 權限
     * @param string $name        名稱
     *
     * @return
     */
    public function modify($id, $permissions, $name)
    {
        $group = Role::find($id);
        $group->menus()->sync($permissions);
        $group->name = $name;
        $group->updated_at = Carbon::now();
        $group->save();
    }

    public function getGameServerStatus()
    {
        $result = DB::connection('mysql4')->table('GAME_REDIRECT')->where('No', 1)->get();

        return $result;
    }

    public function upGameServerStatus($Port, $Enable)
    {
        DB::connection('mysql4')->table('GAME_REDIRECT')->where('Port', $Port)->update(['Enable' => $Enable]);
        DB::connection('mysql4')->table('GGCONFIG')->where('KEY', 'RELOAD')->update(['VALUE' => '2']);
    }

    public function getMaintainOnline()
    {
        $result = DB::connection('mysql4')->table('rooms')->where('room_state', 2)->get();

        return $result;
    }

    /**
     * 新手指南.
     *
     * @param int $id id
     *
     * @return bool
     */
    public function getNoviceBulletin($id)
    {
        if (is_null($id) || trim($id) === '') {
            return NoviceBulletin::orderBy('sort', 'ASC')->get();
        } else {
            return NoviceBulletin::where('id', $id)->first();
        }
    }

    /**
     * 新手指南 - 新增.
     *
     * @param Request $request
     */
    public function noviceBulletinsAdd($request)
    {
        $obj = new NoviceBulletin();
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->button = $request['button'];
        $obj->title = $request['title'];
        $obj->content = $request['content'];
        //先查
        $sort = NoviceBulletin::orderBy('sort', 'desc')->value('sort'); //取得1個值
        $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }

    /**
     * 新手指南 - 編輯.
     *
     * @param int   $id      id
     * @param array $request 參數
     *
     * @return bool
     */
    public function noviceBulletinsEditOk($id, $request)
    {
        $obj = NoviceBulletin::find($id);
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->button = $request['button'];
        $obj->title = $request['title'];
        $obj->content = $request['content'];
        $r = $obj->save();

        return $r;
    }

    /**
     * 新手指南 - 刪除.
     *
     * @param int $id id
     *
     * @return bool
     */
    public function noviceBulletinsDelete($id)
    {
        $user_obj = NoviceBulletin::find($id);
        $del = $user_obj->delete();

        return $del;
    }

    /**
     * 新手指南 - 排序.
     *
     * @param array $data 新順序所有公告
     *
     * @return bool
     */
    public function noviceBulletinsAjax($data)
    {
        foreach ($data as $key => $value) {
            NoviceBulletin::where('id', $value)->update(['sort' => $key]); // 更新所有資料排序
        }
    }
}
