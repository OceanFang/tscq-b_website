<?php

namespace App\Http\Controllers;

use App\Library\MenuName;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(UploadService $up)
    {
        $this->up = $up;
        $this->url = config('site.event.url') . '/get_file.php';
    }

    /**
     * 圖片上傳工具.
     *
     * @param Request $request 參數
     */
    public function imageIndex(Request $request)
    {
        if (app('super') === true) {
            $menuName = new MenuName();
            $title = $menuName->getName();

            $type = $this->up->getParentType('image');
            $types = $type['list'];

            $en_name = ($request->type === null) ? '' : $type['en'][$request->type];
            $list = $this->up->getList($request->type);

            return view('tool.image_upload', compact('request', 'types', 'list', 'en_name', 'title'));
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }

    /**
     * 新增/編輯類型.
     *
     * @param Request $request 參數
     * @param string  $type    類型(video/image)
     */
    public function addParent(Request $request, $type)
    {
        if (app('super') === true) {
            $res = '編輯完成';
            switch ($type) {
                case 'image':
                    $res = $this->up->insParent($request->name, $request->en_name, $type);

                    if ($res === true):
                        $data = array(
                            'method' => 'create',
                            'path' => '/' . $type . 's/' . $request->en_name,
                        );

                        $res = $this->api_curl($this->url, $data);
                    endif;
                    break;

                default:
                    return 'error';
                    break;
            }

            return $res;
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }

    /**
     * 圖片上傳.
     *
     * @param Request $request 參數
     */
    public function imageUpload(Request $request)
    {
        if (app('super') === true) {
            $event_path = '/images/' . $request->path;
            $res_str = '';

            $files = $request->file('file');

            foreach ($files as $file):
                $extension = $file->getClientOriginalExtension();
                $file_name = $file->getClientOriginalName();
                $re_file_name = date("YmdHi") . '_' . $file_name;

                $destination_path = public_path() . '/asset/image/' . $request->path;

                if ($request->hasFile('file')):
                    $file->move($destination_path, $re_file_name);
                endif;

                // $data = array(
                //     'method' => 'upload',
                //     'path' => $event_path,
                //     'file' => curl_file_create($destination_path . $re_file_name),
                //     'name' => urlencode($re_file_name),
                // );

                // $res = $this->api_curl($this->url, $data);
                $res = 'Upload Success.';

                if ($res == 'Upload Success.'):
                    $this->up->insImageSub($request->parentId, $event_path, $re_file_name);
                    // unlink($destination_path . '/' . $re_file_name);
                    $msg = '上傳成功。';
                else:
                    $msg = '上傳失敗。';
                endif;
                $res_str .= '【 ' . $file_name . ' 】 ' . $msg . '<br/>';

            endforeach;

            $request->session()->flash('alert-msg', $res_str);

            return json_encode($res_str);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }

    /**
     * 上傳影片功能主頁.
     *
     * @param Request $request 參數
     *
     * @return
     */
    public function videoIndex(Request $request)
    {
        if (app('super') === true) {
            $menuName = new MenuName();
            $title = $menuName->getName();

            $type = $this->up->getParentType('video');
            $types = $type['list'];

            $en_name = ($request->type === null) ? '' : $type['en'][$request->type];
            $list = $this->up->getList($request->type);

            return view('tool.video_upload', compact('request', 'types', 'list', 'en_name', 'title'));
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }

    /**
     * 刪除類型. (目前僅刪除後台資料庫,event資料夾與檔案不會同步刪除).
     *
     * @param Request $request 參數
     *
     * @return srting 結果
     */
    public function delParent(Request $request)
    {
        $result = $this->up->delParent($request->type, $request->delete_array);

        if ($result == '0') {
            return '刪除失敗';
        } elseif ($request->type == 'video' && $result == 'exist') {
            return '類別下已有影片者無法刪除';
        }

        return 'success';
    }

    /**
     * 上傳影片.
     *
     * @param Request $request 參數
     *
     * @return string
     */
    public function videoUpload(Request $request)
    {
        if (app('super') === true) {
            $event_path = '/mj/video/' . $request->path;
            $res_str = '';

            $files = $request->file('file');
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();

                    $file_name = $file->getClientOriginalName();
                    $destination_path = public_path() . '/asset/video/';

                    if ($request->hasFile('file')):
                        $file->move($destination_path, $file_name);
                    endif;

                    $data = array(
                        'method' => 'upload',
                        'path' => $event_path,
                        'file' => curl_file_create($destination_path . $file_name),
                        'name' => urlencode($file_name),
                    );

                    $res = $this->api_curl($this->url, $data);

                    if ($res == 'Upload Success.') {
                        $this->up->insVideoSub($request, $event_path, $file_name);
                        unlink($destination_path . '/' . $file_name);
                        $msg = '上傳成功。';
                    } else {
                        $msg = '上傳失敗。';
                    }

                    $res_str .= '【 ' . $file_name . ' 】 ' . $msg . '<br/>';
                }
            } else {
                // 編輯只能修改內容，不能修改檔案與類型
                $editId = $request->edit_id;
                if (!is_null($editId) && $editId != '' && $editId > 0) {
                    // 取得原本檔案內容
                    $fileInfo = $this->up->getFileInfo($editId);
                    $request->parentId = $fileInfo->parent;
                    $this->up->insVideoSub($request, $fileInfo->folder, $fileInfo->file_name);
                    $res_str .= '【 ' . $fileInfo->file_name . ' 】 編輯完成<br/>';
                }
            }

            $request->session()->flash('alert-msg', $res_str);

            return json_encode($res_str);
        } else {
            // 若無此權限則顯示提醒頁面
            return 'error';
        }
    }

    /**
     * 刪除檔案. (目前僅刪除後台資料庫,event資料夾與檔案不會同步刪除).
     *
     * @param Request $request 參數
     *
     * @return srting 結果
     */
    public function delSub(Request $request)
    {
        $result = $this->up->delSub($request->delete_array);

        if (!$result || $result == 0) {
            return '刪除失敗';
        }

        return 'success';
    }

    public function api_curl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
