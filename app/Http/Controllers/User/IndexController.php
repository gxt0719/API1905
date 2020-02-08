<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Auth;
use App\Model\UserPubKeyModel;
class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addSSHKey1()
    {
        $data = [];
        return view('user.addkey');
    }
    /**
     * 用户添加公钥
     */
    public function addSSHKey2()
    {
        $key = trim($_POST['sshkey']);
        $uid = Auth::id();
        $user_name = Auth::user()->name;
        $data = [
            'uid'       => $uid,
            'name'      => $user_name,
            'pubkey'    => trim($key)
        ];
        //如果有记录则删除
        UserPubKeyModel::where(['uid'=>$uid])->delete();
        //添加新纪录
        $kid = UserPubKeyModel::insertGetId($data);
        if($kid){
            //页面跳转
            header('Refresh: 3; url=' . env('APPI_URL') . '/home');
            echo "添加成功 公钥内容： >>> </br>" . $key;
            echo '</br>';
            echo "页面跳转中...";
        }
    }
    /**
     *
     */
    public function decrypt1()
    {
        return view('user.decrypt1');
    }
    public function decrypt2()
    {
        $enc_data = trim($_POST['enc_data']);
        echo "加密数据： ".$enc_data;echo '</br>';
        //解密
        $uid = Auth::id();
        //echo "用户ID: ".$uid;
        $u = UserPubKeyModel::where(['uid'=>$uid])->first();
        //echo '<pre>';print_r($u->toArray());echo '</pre>';
        $pub_key = $u->pubkey;
        openssl_public_decrypt(base64_decode($enc_data),$dec_data,$pub_key);
        echo '<hr>';
        echo "解密数据：". $dec_data;
    }
    public function de(){
        $data='hello word';
        $data=base64_encode($data);
        //$da=base64_encode($data);
        echo $data;
    }
     public function decrypt3()
    {
        // 接收加密的数据
        $enc_data_str=$_GET['data'];
        echo "接受的base64密文：".$enc_data_str;
        echo "<hr>";
        $base64_decode_str=base64_decode($enc_data_str);
        echo "解密base64的密文：".$base64_decode_str;
        echo "<hr>";
        // 使用公钥解密
        $pub_key=file_get_contents(storage_path('keys/pub.key'));
        openssl_public_decrypt($base64_decode_str, $dec_data, $pub_key);
        echo "解密数据：".$dec_data;
    }
    public function encrypt3()
    {
        $priv_key=file_get_contents(storage_path('keys/priv.key'));
        $pub_key=file_get_contents(storage_path('keys/pub.key'));
        // echo $priv_key;die;


        echo "<hr>";


        $data='hello word';
        echo "待加密数据".$data;echo "</br>";


        // 私钥加密
        openssl_private_encrypt($data, $enc_data, $priv_key);
        var_dump($enc_data);
        echo "<hr>";


        // 发送加密密文
        $base64_encode_str=base64_encode($enc_data); // 密文 经 base64 编码
        //$url='http://api.1905.com/user/decrypt3?data='.urlencode($base64_encode_str);
        // 发送请求
        //$response=file_get_contents($url);
        echo 'base64 密文:'.$base64_encode_str;die;


        // // 对应公钥解密
        // openssl_public_decrypt($enc_data, $dec_data, $pub_key);
        // echo "解密数据为：".$dec_data;
    }
}