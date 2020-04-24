<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
class CartController extends Controller
{
    public function cartlist(){
    	$user_id  = session('member')->member_id;

    	$cart = \DB::select("select * ,buy_number*goods_price as price from cart where user_id=?",[$user_id]);
//dd($cart);
    	//每个商品的购买数量
    	$buy_number = array_column($cart, 'buy_number');
    	//dump($buy_number);
    	//总购买商品件数
    	$count = array_sum($buy_number);
    	//dd($count);
    	//购物车ID
    	$cart_id = array_column($cart, 'cart_id');

    	$checkedbuynumber=array_combine($cart_id,$buy_number);

    	//总价格
    	$totalprice = array_sum(array_column($cart, 'price'));
    	//dd($totalprice);
    	//return view('index.cartlist',['cart'=>$cart,'count'=>$count,'checkedbuynumber'=>$checkedbuynumber]);
    	return view('index.cartlist',compact('cart','count','checkedbuynumber','totalprice'));
    }
}
