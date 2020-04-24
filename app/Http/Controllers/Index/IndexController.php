<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    public function index(){
    	//使用cache门面
    	//$slide = Cache::get('slide');
    	//使用redis门面
    	//Redis::del('slide');
    	$slide = Redis::get('slide');
    	//使用辅助函数
    	//cache(['slide' => null], 60);
    	//$slide = cache('slide');
    	//dump($slide);
    	if(!$slide){
    		//echo "DB==";
    		//首页幻灯片
    		$slide = Goods::getIndexSlide();
    		//使用cache门面
    		//Cache::put('slide',$slide,60);
    		//使用redis门面
    		$slide = serialize($slide);
    		Redis::setex('slide',60,$slide);
    		//使用辅助函数
    		//cache(['slide' => $slide], 60);
    	}

		$slide = unserialize($slide);
    	//dd($slide);
    	return view('index.index',['slide'=>$slide]);
    }
}
