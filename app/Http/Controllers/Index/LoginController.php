<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
use App\Member;
class LoginController extends Controller
{
    public function login(){

    	return view('index.login');
    }

    public function reg(){
    	
    	return view('index.reg');
    }

    public function sendSms(Request $request){
    	$mobile = $request->mobile;
    	//php 验证手机号
    	$reg = '/^1[3|5|6|7|8|9]\d{9}$/';
    	//dd(preg_match($reg,$mobile));
    	if(!preg_match($reg,$mobile)){
    		echo json_encode(['code'=>'00001','msg'=>'手机号格式不正确']);exit;
    	}
    	$code = rand(100000,999999);
    	//发送
    	$res = $this->sendByMobile($mobile,$code);
    	if($res['Message']=='OK'){
    		session(['code'=>$code]);
    		echo json_encode(['code'=>'00000','msg'=>'发送成功']);exit;
    	}
    }

    public function sendByMobile($mobile,$code){
		// Download：https://github.com/aliyun/openapi-sdk-php
		// Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

		AlibabaCloud::accessKeyClient('LTAI4GCSurmNxtQ1z9xwu1H2', '4gIMcHNauaF3nCfcvRzmsZcShffswm')
		                        ->regionId('cn-hangzhou')
		                        ->asDefaultClient();

		try {
		    $result = AlibabaCloud::rpc()
		                          ->product('Dysmsapi')
		                          // ->scheme('https') // https | http
		                          ->version('2017-05-25')
		                          ->action('SendSms')
		                          ->method('POST')
		                          ->host('dysmsapi.aliyuncs.com')
		                          ->options([
		                                        'query' => [
		                                          'RegionId' => "cn-hangzhou",
		                                          'PhoneNumbers' => $mobile,
		                                          'SignName' => "一品学堂",
		                                          'TemplateCode' => "SMS_184105081",
		                                          'TemplateParam' => "{code:$code}",
		                                        ],
		                                    ])
		                          ->request();
		    return $result->toArray();
		} catch (ClientException $e) {
		    return $e->getErrorMessage() . PHP_EOL;
		} catch (ServerException $e) {
		    return $e->getErrorMessage() . PHP_EOL;
	}

    }

    public function sendEmail(Request $request){
    	$email = $request->email;

    	//php 验证手机号
    	$reg = '/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/';
   		//dd(preg_match($reg,$email));
    	if(!preg_match($reg,$email)){
    		echo json_encode(['code'=>'00001','msg'=>'邮箱格式不正确']);exit;
    	}
    	$code = rand(100000,999999);

    	$this->sendByEmail($email,$code);

    	session(['code'=>$code]);
        echo json_encode(['code'=>'00000','msg'=>'发送成功']);exit;
    }
    //使用邮箱发送验证码
    public function sendByEmail($email,$code){
    	Mail::to($email)->send(new SendCode($code));
    	
    }

    public function logindo(){
        $post = request()->except('_token');
       // dd($post);

        $user = Member::where('username',$post['username'])->first();

        if(decrypt($user->pwd)!=$post['pwd']){
            return redirect('/login')->with('msg','用户名或者密码不对！');
        }

       
        session(['member'=>$user]);
        if($post['refer']){
            return redirect($post['refer']);
        }
        return redirect('/');


    }


}
