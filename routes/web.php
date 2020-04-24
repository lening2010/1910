<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//闭包路由
Route::get('/aa', function () {
    return '这是一个闭包路由';
});
//走控制器方法的路由
//返回视图的两种方式
//Route::get('/index','IndexController@index');
//路由视图
Route::view('/index','index',['name'=>'张庆meimei']);
//举例post方式请求
Route::get('/user/add','IndexController@index');
Route::post('/user/doadd','IndexController@doadd')->name('doadd');

//必填参数
// Route::get('/goods/{id}', function ($goods_id) {
//     return $goods_id;
// });
// Route::get('/goods/{id}','IndexController@good');
// Route::get('/goods/{id}/{name?}','IndexController@goods')->where(['name'=>'[a-zA-Z\x{4e00}-\x{9fa5}]{3,6}']);

//可选参数
// Route::get('/show/{id?}',function ($id=0) {
//     return $id;
// });
Route::get('/show/{id?}','IndexController@show');
//混合参数
Route::get('/detail/{id}/{name?}','IndexController@detail');

Route::domain('admin.laravel.com')->group(function (){
	//品牌管理
	Route::prefix('/brand')->middleware('auth')->group(function(){
		//Route::get('/','Admin\BrandController@index');//列表展示
		//支持多种请求方式
		//Route::match(['get','post'],'/','Admin\BrandController@index');//列表展示
		Route::any('/','Admin\BrandController@index');//列表展示

		Route::get('create','Admin\BrandController@create');//添加页面
		Route::post('store','Admin\BrandController@store');//执行添加
		Route::get('edit/{id}','Admin\BrandController@edit');//编辑展示
		Route::post('update/{id}','Admin\BrandController@update');//执行添加
		Route::get('destroy/{id}','Admin\BrandController@destroy');//删除
	});
	//分类管理
	Route::prefix('/cate')->middleware('auth')->group(function(){
		Route::get('/','Admin\CateController@index');//列表展示
		Route::get('create','Admin\CateController@create');//添加页面
		Route::post('store','Admin\CateController@store');//执行添加
		Route::get('edit/{id}','Admin\CateController@edit');//编辑展示
		Route::post('update/{id}','Admin\CateController@update');//执行添加
		Route::get('destroy/{id}','Admin\CateController@destroy');//删除
	});
	//Route::prefix('/goods')->middleware('islogin')->group(function(){
	Route::prefix('/goods')->middleware('auth')->group(function(){	
		Route::get('/','Admin\GoodsController@index');//列表展示
		Route::get('create','Admin\GoodsController@create');//添加页面
		Route::post('store','Admin\GoodsController@store')->name('goodsstore');//执行添加
		Route::get('edit/{id}','Admin\GoodsController@edit');//编辑展示
		Route::post('update/{id}','Admin\GoodsController@update')->name('goodsupdate');//执行添加
		Route::get('destroy/{id}','Admin\GoodsController@destroy');//删除
	});

	// Route::view('/login','admin.login');
	// Route::post('/logindo','Admin\LoginController@logindo');

	//cookie的应用
	Route::get('/setcookie','IndexController@setcookie');//设置
	Route::get('/getcookie','IndexController@getcookie');//获取

	Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');
});

Route::domain('www.laravel.com')->group(function (){
	//前台
	Route::get('/','Index\IndexController@index')->name('shop.index');
	Route::get('/login','Index\LoginController@login');
	Route::post('/logindo','Index\LoginController@logindo');
	Route::get('/reg','Index\LoginController@reg');

	//手机发送验证码
	Route::post('/sendSms','Index\LoginController@sendSms');
	//邮箱发送验证码
	Route::get('/sendEmail','Index\LoginController@sendEmail');

	Route::get('/goods/{id}','Index\GoodsController@index')->name('shop.goods');
	Route::get('/addcar','Index\GoodsController@addcar');
	Route::get('/cartlist','Index\CartController@cartlist')->name('shop.cartlist');
});



