<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
   //指定表名
    protected $table = 'category';
    //指定主键
    protected $primaryKey = 'cate_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
