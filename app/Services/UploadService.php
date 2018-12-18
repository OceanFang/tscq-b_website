<?php

namespace App\Services;

use App\Repository\UploadRepository;

class UploadService
{
    protected $paraRepo;
    protected $repo;

    public function __construct(UploadRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getParentType($type)
    {
        $result = $this->repo->getParentType($type);

        return $result;
    }

    public function getList($parent)
    {
        $result = [];

        if ($parent != '') {
            $result = $this->repo->getList($parent);
        }

        return $result;
    }

    public function insParent($name = '', $en_name = '', $type = 'image')
    {
        $result = [];

        if ($name != '') {
            $result = $this->repo->insParent($name, $en_name, $type);
        }

        return $result;
    }

    public function insImageSub($parent, $folder, $file_name)
    {
        $result = [];

        if ($parent != '') {
            $result = $this->repo->insImageSub($parent, $folder, $file_name);
        }

        return $result;
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
        return $this->repo->getFileInfo($id);
    }

    /**
     *  編輯類型名稱.
     *
     * @param obj    $request 參數
     * @param string $type    類型(image,video)
     *
     * @return bool
     */
    public function editParentName($request, $type)
    {
        $typeLists = $request->type_lists;
        $typeArray = explode(',', $typeLists);
        foreach ($typeArray as $typeId) {
            if ($typeId == '0') {
                continue;
            }
            $column = 'type_'.$typeId;
            $newName = $request->$column;
            if (trim($newName) != '' && strlen($newName) <= 32) {
                $content = ['name' => trim($newName)];
                $whereClause = ['id' => $typeId, 'type' => $type];
                $this->repo->editType($content, $whereClause);
            } else {
                return '類型名稱不可為空，長度需小於32字元';
            }
        }

        return 'done';
    }

    /**
     *  新增類型名稱.
     *
     * @param obj    $request 參數
     * @param string $type    類型(image,video)
     *
     * @return bool
     */
    public function createParentName($request, $type)
    {
        $insertArray = [];
        $new_type_tw = $request->new_type_tw;
        $new_type_en = $request->new_type_en;

        foreach ($new_type_tw as $index => $name) {
            if (trim($name) != '' && strlen($name) <= 32) {
                $insertArray[$index]['name'] = trim($name);
                $insertArray[$index]['type'] = 'video';
            } else {
                return ['status' => '類型名稱不可為空，長度需小於32字元', 'insertArray' => []];
            }
        }

        foreach ($new_type_en as $enindex => $enname) {
            if (trim($enname) != '' && strlen($enname) <= 32) {
                if (preg_match("/^[\w-]*$/i", $enname)) {
                    if (isset($insertArray[$enindex]['name'])) {
                        $insertArray[$enindex]['en_name'] = trim($enname);
                    }
                } else {
                    return ['status' => '類型英文名稱僅可使用英文、數字以及"-"與"_"符號', 'insertArray' => []];
                }
            } else {
                return ['status' => '類型名稱不可為空，長度需小於32字元', 'insertArray' => []];
            }
        }

        $this->repo->createType($insertArray);

        return ['status' => 'done', 'insertArray' => $insertArray];
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
        switch ($deleteType) {
            case 'video':
                // 檢查類型下是否存在影片
                $hasVideo = $this->repo->videoInType($deleteArray);
                if ($hasVideo > 0) {
                    return 'exist';
                }

                return $this->repo->delParent($deleteType, $deleteArray);
                break;
            default:
                return $this->repo->delParent($deleteType, $deleteArray);
                break;
        }

        return '0';
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
        return $this->repo->delSub($deleteArray);
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
        return $this->repo->insVideoSub($request, $folder, $file_name);
    }
}
