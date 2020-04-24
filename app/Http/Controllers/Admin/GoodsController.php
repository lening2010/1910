<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cate;
use App\Brand;
use App\Goods;
use DB;
use App\Http\Requests\StoreGoodsPost;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(session('adminuser'));

        // //设置session
        // request()->session()->put('name','zhangsan');
        // session(['age'=>18]);

        // //获取
        // echo request()->session()->get('name');
        // echo session('age');

        // //删除
        // request()->session()->forget('name');
        // session(['name'=>null]);

        // //取所有
        // dump(request()->session()->all());
        // //删除所有
        // request()->session()->flush();
        // //判断session有没有name
        // dump(request()->session()->has('name'));

        $goods_name = request()->goods_name;
        $where=[];
        if($goods_name){
            $where[] = ['goods_name','like',"%$goods_name%"];
        }

        $cate_id = request()->cate_id;
        if($cate_id){
            $where[] = ['goods.cate_id',$cate_id];
        }
        $brand_id = request()->brand_id;
        if($brand_id){
            $where[] = ['goods.brand_id',$brand_id];
        }
        //商品分类
        $cate = Cate::all();
        $cate = createTree($cate);
        //品牌
        $brand = Brand::all();

       // DB::connection()->enableQueryLog();
        $pageSize = config('app.pageSize');
        $goods = Goods::getGoods($where,$pageSize);
         // $logs = DB::getQueryLog();        
         // dump($logs );  
        $query = request()->all();
        

      //  dump($query);
        return view('admin.goods.index',['goods'=>$goods,'cate'=>$cate,'brand'=>$brand,'query'=>$query]);      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Cate::all();
        $cate = createTree($cate);

        $brand = Brand::all();
        return view('admin.goods.create',['categorylist'=>$cate,'brandlist'=>$brand]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoodsPost $request)
    {
        $post = $request->except('_token');
       // dump($post);
        //上传商品主图
        if ( $request->hasFile('goods_img') ){
            $post['goods_img'] = upload('goods_img');
        }

        //上传商品相册
        if(isset($post['goods_imgs'])){
            $imgs = MoreUpload('goods_imgs');
            $post['goods_imgs']= implode('|',$imgs);
        } 
        
        $res = Goods::create($post);
        if($res){
            return redirect('/goods');
        }

    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Cate::all();
        $cate = createTree($cate);

        $brand = Brand::all();
        $goods = Goods::find($id);
        return view('admin.goods.edit',['categorylist'=>$cate,'brandlist'=>$brand,'goods'=>$goods]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGoodsPost $request, $id)
    {
        $post = $request->except('_token');
       // dump($post);
        //上传商品主图
        if ( $request->hasFile('goods_img') ){
            $post['goods_img'] = upload('goods_img');
        }

        //上传商品相册
        if(isset($post['goods_imgs'])){
            $imgs = MoreUpload('goods_imgs');
            $post['goods_imgs']= implode('|',$imgs);
        } 
        
        $res = Goods::where('goods_id',$id)->update($post);
        if($res!==false){
            return redirect('/goods');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

// 作业：完成管理员的curd 
// 字段要求：
// 管理员名称、手机号、邮箱、密码、添加时间
// 规则要求
// 1：管理员名称：必填、唯一、中文字母数字组成、 不超过18位
// 2：手机号：必须手机号
// 3：邮:箱：邮箱格式
// 4：密码：6-12位  确认密码和密码需一致