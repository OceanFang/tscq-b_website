<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Bulletin extends Model
{
    //此模型的連接名稱。
    protected $connection = 'mysql4';
    //與模型關聯的資料表。
    //protected $table = 'Marquees';
    public $timestamps = false; //指定是否模型應該被戳記時間。
}
