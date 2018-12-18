<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class LauncherBanner extends Model
{
    protected $connection = 'mysql4'; //此模型的連接名稱。
    public $timestamps = false; //指定是否模型應該被戳記時間。
}
