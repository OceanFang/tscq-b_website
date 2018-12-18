<?php
#共用套件區
namespace App\Library;

use Auth;
use Excel;
use Mail;

class Accessibility
{
    #匯出excel
    public function export($filename, $datas)
    {
        Excel::create($filename, function ($excel) use ($datas, $filename) {
            $excel->sheet('report', function ($sheet) use ($datas) {
                $sheet->row(1, $datas[0]); //標題
                $sheet->rows($datas[1]); //資料
            });
            $excel->setTitle('example');
        })->export('xls');
    }

    #email發送
    public function email($emailData)
    {
        Mail::queue($emailData['blade'], $emailData, function ($message) use ($emailData) {
            $message->to($emailData['email'])->subject($emailData['subject']);
        });
    }

    public function emailWithTwoAtta($emailData)
    {
        Mail::queue($emailData['blade'], $emailData, function ($message) use ($emailData) {
            $message->to($emailData['email'])->subject($emailData['subject'])
                ->attach($emailData['attachment1']['path'], ['as' => $emailData['attachment1']['display']])
                ->attach($emailData['attachment2']['path'], ['as' => $emailData['attachment2']['display']]);
        });
    }

    #取得會員ID
    public function getUserId()
    {
        $userId = Auth::user()->id;

        return $userId;
    }
}
