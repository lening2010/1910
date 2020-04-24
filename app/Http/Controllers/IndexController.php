<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    //设置cookie
    public function setcookie(){
        //第一种设置
        //return response('设置cookie')->cookie('name','乐柠',1);
        //第二种
        //Cookie::queue(Cookie::make('age', '100', 1));
        //第三种
        Cookie::queue('num', 110, 1);
    }
    //获取cookie
    public function getcookie(){
        //第一种获取
        //echo request()->cookie('name');
        //第二种
        echo Cookie::get('num');
    }

    public function index(){
    	//echo "这是控制器的index方法";
    	
    	return view('index',['name'=>'张庆']);
    }


    public function doadd(){
    	$post = request()->all();
    	dd($post);
    }
	public function good($goods_id){
    	echo '单个：'.$goods_id;
    	
    }
    public function goods($goods_id,$name){
    	echo $goods_id;
    	echo $name;
    }
    public function show($id=0){
    	echo '可选：'.$id;
    	
    }

    public function detail($id,$name=null){
    	echo $id;
    	dd($name) ;
    }

}
