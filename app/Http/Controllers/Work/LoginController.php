<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;
class LoginController extends Controller
{
	public function login()
	{
		//echo 111;
		return view('login.login');
	}

	public function loginDo()
	{

        $data=request()->except(['_token']);

        $user_name=\request()->post("user_name");
        if(!empty($data)){
            $adminInfo=Login::where(['user_name'=>$data['user_name']])->first();
            //print_r($adminInfo);
            if($data['user_pwd']==$adminInfo['user_pwd']){
                session(['adminInfo'=>$adminInfo]);
                
            }else{
                echo "账号或密码错误";
                return view('login/login');exit;
            }
        }
       return view("/login/index",['user_name'=>$user_name]);
       
    
	}
    
	public function index(){
         return view('login/index');
	}
    //注册
	public function register()
	{
        return view('login.register');
	}
    //注册执行
	public function registerDo()
	{
        $data=request()->except('_token');
    	
    	$res=Login::create($data);
    	if($res){
    		return redirect('/login/login');
    	}else{
    		return redirect('login/register');
    	}
	}
}