<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cart;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    public function index($id){
    	//访问量
        $visit = Redis::setnx('visit_'.$id,1)?1:Redis::incr('visit_'.$id);
        //dd($count);

    	$goods = Goods::find($id);
    	
    	return view('index.goods',['goods'=>$goods,'visit'=>$visit]);
    }

    /**
     * 判断用户是否登录
     * 未登录  跳转到登录页面 登录后返回此商品详情页
     * 登录；
     * 		//判断上下架
     *     1 判断商品库存是否大于购买数量  如果小于提示库存不足
     *     2 判断购物车表内是否有次商品添加记录 
     *     有 购买数量相加，判断商品库存是否大于购买数量  如果小于 购买数量=最大库存  否则更新购物车列表次商品的购买数量
     * 	    无  添加入库 
     */ 
    public function addcar(){
    	$goods_id = request()->goods_id;
    	$buy_number = request()->buy_number;
    	$user = session('member');
    	if(!$user){  ShowMsg('00001','未登录'); }

    	$goods = Goods::select('goods_id','goods_name','goods_img','goods_price','goods_num')->find($goods_id);
    	//dd($goods);
    	if( $goods->goods_num < $buy_number ){ ShowMsg('00002','库存不足'); }
    	$where=[
    		'user_id'=>$user->member_id,
    		'goods_id'=>$goods_id
    	];
    	$cart = Cart::where($where)->first();
    	if($cart){
    		//更新购买数量
    		$buy_number = $cart->buy_number+$buy_number;
    		
    		if( $goods->goods_num < $buy_number){
    			$buy_number = $goods->goods_num;
    		}
    		$res = Cart::where('cart_id',$cart->cart_id)->update(['buy_number'=>$buy_number]);
    	}else{
    		//添加购物车数据
    		$data = [
    			'user_id'=>$user->member_id,
    			'buy_number'=>$buy_number,
    			'addtime'=>time()
    		];	
    		$data = array_merge($data,$goods->toArray());
    		unset($data['goods_num']);
    		$res = Cart::create($data);	
    	}

    	if($res!==false){
    		ShowMsg('00000','成功');
    	}
    }

}
