<?php

namespace App\Services;

use App\Repository\ToolRepository;

//載入這支

class ToolService
{
    protected $tr;

    public function __construct(ToolRepository $tr)
    {
        $this->tr = $tr;
    }

    //banner編輯器->新增
    public function banner_add($request)
    {
        return $this->tr->banner_add($request);
    }

    //banner編輯器->編輯
    public function banner_edit($request)
    {
        return $this->tr->banner_edit($request);
    }

    //banner編輯器->刪除
    public function banner_delete($id)
    {
        return $this->tr->banner_delete($id);
    }

    //banner編輯器->排序
    public function banner_ajax($data)
    {
        return $this->tr->banner_ajax($data);
    }

    //launcher banner編輯器->新增
    public function launcher_banner_add($request)
    {
        return $this->tr->launcher_banner_add($request);
    }

    //launcher banner編輯器->編輯
    public function launcher_banner_edit($request)
    {
        return $this->tr->launcher_banner_edit($request);
    }

    //launcher banner編輯器->刪除
    public function launcher_banner_delete($id)
    {
        return $this->tr->launcher_banner_delete($id);
    }

    //launcher banner編輯器->排序
    public function launcher_banner_ajax($data)
    {
        return $this->tr->launcher_banner_ajax($data);
    }

    //ingame banner編輯器->新增
    public function ingame_banner_add($request)
    {
        return $this->tr->ingame_banner_add($request);
    }

    //ingame banner編輯器->編輯
    public function ingame_banner_edit($request)
    {
        return $this->tr->ingame_banner_edit($request);
    }

    //ingame banner編輯器->刪除
    public function ingame_banner_delete($id)
    {
        return $this->tr->ingame_banner_delete($id);
    }

    //ingame banner編輯器->排序
    public function ingame_banner_ajax($data)
    {
        return $this->tr->ingame_banner_ajax($data);
    }

    //公告編輯器->新增
    public function bulletins_add($request)
    {
        return $this->tr->bulletins_add($request);
    }

    //公告編輯器->編輯
    public function bulletins_edit($id, $request)
    {
        return $this->tr->bulletins_edit($id, $request);
    }

    //公告編輯器->刪除
    public function bulletins_delete($id)
    {
        return $this->tr->bulletins_delete($id);
    }

    //公告編輯器->排序
    public function bulletins_ajax($data)
    {
        return $this->tr->bulletins_ajax($data);
    }

    //events編輯器->新增
    public function events_add($request)
    {
        return $this->tr->events_add($request);
    }

    //events編輯器->編輯
    public function events_edit($id, $request)
    {
        return $this->tr->events_edit($id, $request);
    }

    //events編輯器->刪除
    public function events_delete($id)
    {
        return $this->tr->events_delete($id);
    }
}
