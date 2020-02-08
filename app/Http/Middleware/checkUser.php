<?php 
namespace App\Http\Middleware;
use Closure;
use App\Model\User;
use Illuminate\Support\Facades\Redis;
class checkUser
{
	public function handle($request,Closure $next)
	{
		
		/**
     * 获取用户列表 
     */
    	//print_r($_SERVER);die;
    	$user_token=$_SERVER['HTTP_POSTMAN_TOKEN'];
    	// echo "http_token".$user_token;echo '<hr>';
    	$current_url=$_SERVER['REQUEST_URI'];
    	// echo "当前url".$current_url;echo '<hr>';


    	$redis_key='str:count:url:'.md5($current_url);
    	// echo 'redis key:'.$redis_key;echo '<hr>';


    	// 取出计数 访问次数
    	$count=Redis::get($redis_key);
    	echo "接口访问的次数".$count;echo '<hr>';


    	// 判断最多访问次数
    	if($count>=10){
    		echo "访问次数已达到次数，请不要频繁刷新此接口，稍后再试。";
    		Redis::expire($redis_key,30);die;
    	}


    	// 计数 存入redis
    	$count=Redis::incr($redis_key);
    	// echo 'count:'.$count;
    }
	
}
?>