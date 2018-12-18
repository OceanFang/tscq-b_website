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
    public function banner_editok($request)
    {
        return $this->tr->banner_editok($request);
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
    public function launcher_banner_editok($request)
    {
        return $this->tr->launcher_banner_editok($request);
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

    //跑馬燈刪除
    public function marquee_delete($id)
    {
        return $this->tr->marquee_delete($id);
    }
    //跑馬燈.編輯
    public function marquee_edit($id, $content)
    {
        return $this->tr->marquee_edit($id, $content);
    }
    //跑馬燈編輯器->排序
    public function marquee_ajax($data)
    {
        return $this->tr->marquee_ajax($data);
    }

    //公告編輯器->新增
    public function bulletins_add($request)
    {
        return $this->tr->bulletins_add($request);
    }
    //公告編輯器->編輯
    public function bulletins_editok($id, $request)
    {
        return $this->tr->bulletins_editok($id, $request);
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

    //game server status
    public function getGameServerStatus()
    {
        return $this->tr->getGameServerStatus();
    }

    //update game server status
    public function upGameServerStatus($Port, $Enable)
    {
        return $this->tr->upGameServerStatus($Port, $Enable);
    }

    //進行牌局玩家
    public function getMaintainOnline()
    {
        return $this->tr->getMaintainOnline();
    }

    /**
     * 新手指南.
     *
     * @param int $id id
     *
     * @return bool
     */
    public function getNoviceBulletin($id = null)
    {
        return $this->tr->getNoviceBulletin($id);
    }

    /**
     * 新手指南 - 新增.
     *
     * @param Request $request
     */
    public function noviceBulletinsAdd($request)
    {
        return $this->tr->noviceBulletinsAdd($request);
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
        return $this->tr->noviceBulletinsEditOk($id, $request);
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
        return $this->tr->noviceBulletinsDelete($id);
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
        return $this->tr->noviceBulletinsAjax($data);
    }
}
