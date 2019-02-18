<?php

namespace App\Repository;

use App\Banner; //banner
use App\Bulletin; //公告
use App\IngameEventBanner; //launcher banner
use App\LauncherBanner;
use DB;

//ingame banner

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
    public function banner_edit($request)
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

    //banner編輯器->排序
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
    public function launcher_banner_edit($request)
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

    //ingame banner編輯器->新增
    public function ingame_banner_add($request)
    {
        $obj = new IngameEventBanner();
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->description = $request['description'];
        $obj->img = $request['img'];
        $obj->url = $request['url'];
        //先查
        $sort = IngameEventBanner::orderBy('sort', 'desc')->value('sort'); //取得1個值
        $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }

    //ingame banner編輯器->編輯
    public function ingame_banner_edit($request)
    {
        $obj = IngameEventBanner::find($request->id);
        $obj->start_time = $request->start_time;
        $obj->end_time = $request->end_time;
        $obj->description = $request->description;
        $obj->img = $request->img;
        $obj->url = $request->url;
        $r = $obj->save();

        return $r;
    }

    //ingame banner編輯器->刪除
    public function ingame_banner_delete($id)
    {
        $user_obj = IngameEventBanner::find($id);
        $del = $user_obj->delete();

        return $del;
    }

    //ingame banner燈編輯器->排序
    public function ingame_banner_ajax($data)
    {
        foreach ($data as $key => $value) {
            IngameEventBanner::where('id', $value)->update(['sort' => $key]); // 更新所有資料排序
        }
    }

    //公告編輯器->新增
    public function bulletins_add($request)
    {

        Bulletin::where('game', $request['game'])->update(['sort' => DB::raw('sort + 1')]);

        $obj = new Bulletin();
        $obj->game = $request['game'];
        $obj->start_time = $request['start_time'];
        $obj->end_time = $request['end_time'];
        $obj->type_id = $request['type_id'];
        $obj->title = $request['title'];
        $obj->content = $request['content'];
        //先查
        // $sort = Bulletin::orderBy('sort', 'desc')->value('sort'); //取得1個值
        // $obj->sort = $sort + 1;
        $r = $obj->save();

        return $r;
    }

    //公告編輯器->編輯
    public function bulletins_edit($id, $request)
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

    //公告編輯器->排序
    public function bulletins_ajax($data)
    {

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

}
