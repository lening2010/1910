<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    	//指定表名
    protected $table = 'admin';
    //指定主键
    protected $primaryKey = 'admin_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
