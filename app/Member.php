<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //指定表名
    protected $table = 'member';
    //指定主键
    protected $primaryKey = 'member_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
