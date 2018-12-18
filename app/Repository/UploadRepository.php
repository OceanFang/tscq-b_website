<?php

namespace App\Repository;

use DB;

class UploadRepository
{
    public function __construct()
    {
        $this->tb_name = 'upload_methods';
        $this->list_tb_name = 'upload_lists';
    }

    public function getParentType($type)
    {
        $result = [];
        $en = [];

        $data = DB::table($this->tb_name)->where('type', $type)->get();

        foreach ($data as $k => $val) {
            $en[$val->id] = $val->en_name;
        }

        $arr = ['list' => $data, 'en' => $en];

        return $arr;
    }

    public function getList($parent)
    {
        $result = DB::table($this->list_tb_name)->where('parent', $parent)->get();

        return $result;
    }

    public function insParent($name = '', $en_name = '', $type)
    {
        $check = DB::table($this->tb_name)->where('en_name', $en_name)->count();

        if ($check > 0):
            return '已建立此類型！';else:

            return DB::table($this->tb_name)->insert(['name' => $name, 'en_name' => $en_name, 'type' => $type]);
        endif;
    }

    public function insImageSub($parent, $folder, $file_name)
    {
        return DB::table($this->list_tb_name)->insert(['parent' => $parent, 'folder' => $folder, 'file_name' => $file_name]);
    }

    /**
     * 編輯類型名稱.
     *
     * @param array $content     修改內容
     * @param array $whereClause 條件
     */
    public function editType($content, $whereClause)
    {
        DB::table($this->tb_name)->where($whereClause)->update($content);
    }

    /**
     * 新增類型名稱.
     *
     * @param array $content 新增類型
     */
    public function createType($insertArray)
    {
        DB::table($this->tb_name)->insert($insertArray);
    }

    /**
     *  刪除類型.
     *
     * @param string $deleteType  刪除類型
     * @param array  $deleteArray 刪除清單
     *
     * @return bool
     */
    public function delParent($deleteType, $deleteArray)
    {
        if (count($deleteArray) > 0) {
            return DB::table($this->tb_name)->where('type', $deleteType)->whereIn('id', $deleteArray)->delete();
        }

        return 0;
    }

    /**
     *  刪除檔案.
     *
     * @param array $deleteArray 刪除清單
     *
     * @return bool
     */
    public function delSub($deleteArray)
    {
        if (count($deleteArray) > 0) {
            return DB::table($this->list_tb_name)->whereIn('id', $deleteArray)->delete();
        }

        return 0;
    }

    /**
     * 撈取類型下是否存在影片.
     *
     * @param array $typeArray 刪除清單
     *
     * @return int 存在影片數
     */
    public function videoInType($typeArray)
    {
        $num = DB::table($this->list_tb_name)->select('id')->whereIn('parent', $typeArray)->count();

        return $num;
    }

    /**
     * 上傳影片.
     *
     * @param object $request   參數
     * @param string $folder    遠端路徑
     * @param string $file_name 檔名
     *
     * @return bool
     */
    public function insVideoSub($request, $folder, $file_name)
    {
        $result = '';

        $editId = $request->edit_id;
        $start = ($request->start_time == '' || is_null($request->start_time)) ? '0000-00-00 00:00:00' : $request->start_time;
        $end = ($request->end_time == '' || is_null($request->end_time)) ? '0000-00-00 00:00:00' : $request->end_time;
        $params = [
            'parent' => $request->parentId,
            'folder' => $folder,
            'file_name' => $file_name,
            'content' => $request->content,
            'url' => $request->url,
            'start' => $start,
            'end' => $end,
            'auto_play' => $request->auto_play,
        ];

        if (is_null($editId) || $editId == '') {
            return DB::table($this->list_tb_name)->insert($params);
        } else {
            return DB::table($this->list_tb_name)->where('id', $editId)->update($params);
        }
    }

    /**
     * 取得檔案內容.
     *
     * @param int $id
     *
     * @return obj
     */
    public function getFileInfo($id)
    {
        return DB::table($this->list_tb_name)->where('id', $id)->first();
    }
}
