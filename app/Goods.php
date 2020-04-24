<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    //指定主键
    protected $primaryKey = 'goods_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];

    public function Brand() {
        return $this->belongsTo('App\Brand'); 
    }

    //获取商品列表数据
    public static function getGoods($where,$pageSize){

    	$goods = self::select('goods.*','category.cate_name','brand.brand_name')
                ->leftJoin('category', 'goods.cate_id', '=', 'category.cate_id')
                ->leftJoin('brand', 'goods.brand_id', '=', 'brand.brand_id')
                ->where($where)
                ->paginate($pageSize);
                
        return $goods;        
    }

    //获取首页幻灯片数据
    public static function getIndexSlide(){
        return self::select('goods_id','goods_img')->where('is_slide',1)->take(5)->get();
    }



}
