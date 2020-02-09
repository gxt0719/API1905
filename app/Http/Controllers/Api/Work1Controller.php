<?php 
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Redis;
use DB;
class Work1Controller extends Controller
{
	//加密
	function jiami(Request $request){
		$str=$request->input('str');
		$arr=range("a", "z");
		//$str='hello';
		//$c=$request->$_GET['str'];
		$c=strlen($str);
		$new_str='';
		for ($i=0; $i <=strlen($str)-1; $i++)
		{ 
		    $n=array_search($str[$i],$arr);
			$n=$n+3;
			if ($n>25) {
				$n=$n-26;
			}
			$new_str.=$arr[$n];
		}
		return $new_str;

	}


	//echo "<br>";
	//解密
	function jiemi(Request $request){
		$str=$request->input('str');
		$arr=range("a","z");
		$old_str='';
		for ($i=0; $i <=strlen($str)-1; $i++)
		{ 
			$n=array_search($str[$i],$arr);
			 $n=$n-3;
			if ($n<0) {
				$n=$n+26;
			}
			 $old_str.=$arr[$n];
			 //echo "<br>";
			 //echo $old_str;
		}
		return $old_str;
	}

    //加密
	public function encode($string = 'helloWord', $skey = 'cxphp')
   {
       $strArr   = str_split(base64_encode($string));
       $strCount = count($strArr);
       foreach (str_split($skey) as $key => $value) {
           $key < $strCount && $strArr[$key] .= $value;
       }
       return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
   }
   //解密
   public function decode($string = 'acGxVpshbpG9Xb3Jk', $skey = 'cxphp')
  {
      $strArr   = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
      $strCount = count($strArr);
      foreach (str_split($skey) as $key => $value) {
          $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
      }
      return base64_decode(join('', $strArr));
  }

    private static $_privkey = '';
    private static $_pubkey = '';
    private static $_isbase64 = false;
    /**
     * 初始化key值
     * @param  string  $privkey  私钥
     * @param  string  $pubkey   公钥
     * @param  boolean $isbase64 是否base64编码
     * @return null
     */
    public  function init($privkey, $pubkey, $isbase64=false){
        self::$_privkey = $privkey;
        self::$_pubkey = $pubkey;
        self::$_isbase64 = $isbase64;
    }
    /**
     * 私钥加密
     * @param  string $data 原文
     * @return string       密文
     */
    public  function priv_encode($data){
        $outval = '';

        $res = openssl_pkey_get_private(self::$_privkey);

        openssl_private_encrypt($data, $outval, $res);
        if(self::$_isbase64){
            $outval = base64_encode($outval);
        }
        return $outval;
    }
    /**
     * 公钥解密
     * @param  string $data 密文
     * @return string       原文
     */
    public  function pub_decode($data){
        $outval = '';
        if(self::$_isbase64){
            $data = base64_decode($data);
        }
        $res = openssl_pkey_get_public(self::$_pubkey);
        openssl_public_decrypt($data, $outval, $res);
        return $outval;
    }
    /**
     * 公钥加密
     * @param  string $data 原文
     * @return string       密文
     */
    public  function pub_encode($data){
        $outval = '';
        $res = openssl_pkey_get_public(self::$_pubkey);
        openssl_public_encrypt($data, $outval, $res);
        if(self::$_isbase64){
            $outval = base64_encode($outval);
        }
        return $outval;
    }
    /**
     * 私钥解密
     * @param  string $data 密文
     * @return string       原文
     */
    public  function priv_decode($data){
        $outval = '';
        if(self::$_isbase64){
            $data = base64_decode($data);
        }
        $res = openssl_pkey_get_private(self::$_privkey);
        openssl_private_decrypt($data, $outval, $res);
        return $outval;
    }
    /**
     * 创建一组公钥私钥
     * @return array 公钥私钥数组
     */
    public function new_rsa_key(){
        $res = openssl_pkey_new();
        openssl_pkey_export($res, $privkey);
        $d= openssl_pkey_get_details($res);
        $pubkey = $d['key'];
        return array(
            'privkey' => $privkey,
            'pubkey'  => $pubkey
        );
    }
}
?>