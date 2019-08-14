<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Tool\wechat;
class WechatController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }
    public function get_user_info()
    {
        $access_token = $this ->get_access_token();
//        dd($access_token);
        $openid='oPi8KuE-fY7qJ7qiKcMfch2Rppnc';
        $wachat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
        $user_info = json_decode($wachat_user,1);
        dd($user_info);
    }
    public function get_user_list()
    {
        $access_token = $this ->get_access_token();
//        dd($access_token);
        //        拉取关注用户列表
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
//        dd($wechat_user);
        $user_info = json_decode($wechat_user,1);
        return $user_info;
    }
//获取access_token
    public function get_access_token()
    {
        //        获取access_token
        $access_token="";
        $redis = new \Redis();
        $redis -> connect('127.0.0.1','6379');
        $access_token_key = 'wechat_access_token';
        if($redis->exists($access_token_key)){
//            去缓存拿
            $access_token = $redis->get($access_token_key);
//            dd($access_token);
        }else{
//            去微信接口拿
            $access_re = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
//        dd($access_re);
            $access_result = json_decode($access_re,1);
            $access_token = $access_result['access_token'];
            $expire_time = $access_result['expires_in'];
//            加入缓存
            $redis->set($access_token_key,$access_token,$expire_time);
//            dd($access_result);
//            $redis->del($access_token_key);
//        dd('ok');

        }

        return $access_token;
    }

    //将用户信息入库
    public function user_list_do_add()
    {
        $user_list_info=$this->get_user_list();
        $open_id=$user_list_info['data']['openid'];
        $access_token=$this->get_access_token();
//        dd($access_token);
        $arr=[];
        foreach($open_id as $v){
            $info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$v}&lang=zh_CN");
            $info=json_decode($info,1);
            $arr[]=[
                'open_id'=>$v,
                'subscribe'=>$info['subscribe'],
                'add_time'=>time()
            ];
        }
        $res=DB::connection('mysql_shop')->table('wechat_openid')->insert($arr);
        if($res){
            echo 'ok';die;
        }else{
            echo 'no';die;
        }
    }

    //用户信息展示
    public function user_list_zhanshi(){
        $info=DB::connection('mysql_shop')->table('wechat_openid')->get()->toarray();
        return view('dibayue/user_list',['data'=>$info]);
    }

    public function user_detail($id)
    {
        //根据id去库里拿数据
        $info=DB::connection('mysql_shop')->table('wechat_openid')->where('id',$id)->get()->toArray();
        $info=array_map('get_object_vars',$info);
//        dd($info);
        //根据库里的open-id和封装好的token调用接口查到用户信息
        $open_id=$info[0]['open_id'];
//        dd($open_id);
        $access_token=$this->get_access_token();
//        dd($access_token);
        $data=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN
");
        $data=json_decode($data,1);
//        dd($data);
        return view('dibayue/user_detail',['data'=>$data,'id'=>$id]);
//        dd($data);
//        然后展示
    }

//有个网页去跳转、集成在h5项目前台的注册登录
    public function login()
    {
        //首先去配置域名-》测试号->网页帐号	网页授权获取用户基本信息	无上限	修改不要加http等东西 一开始就需要
//        $user_is_empty=DB::connection('mysql_shop')->table('wechat_user')->where('open_id',$openid)->get()->toArray();
        $redirect_uri='http://www.shops.com/wechat/get_code';
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }
    //访问获取code 的接口获取ocde、集成在h5项目前台的注册登录
    public function get_code(Request $request)
    {
        $data=$request->all();
//        dd($data);
        $code=$data['code'];

        //根据code 获取access_token（这里的token和获取用户信息的token的不一样）
        $url=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code");
//        dd($url);
        $url=json_decode($url,1);
//        dd($url);
        $access_token=$url['access_token'];
        $openid=$url['openid'];
//        dd($access_token);
//        dd($openid);

        //根绝获取到的token去调用获取用户信息的接口  ---可用 但要用下面更简单的
//        $user_info=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN");
//        $user_info=json_decode($user_info,1);
//        dd($user_info);

        //调用封装好的方法获取用户信息
        $user_info=$this->wechat->get_user_info($openid);
//        dd($user_info);
        //检测access_token是否有效
//        $is_ture=file_get_contents("https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid}");
//        $is_ture=json_decode($is_ture,1);
//        dd($is_ture);
        //获取用户基本信息
        $wechat_user_info = $this->wechat->get_user_info($openid);
        //去user_openid 表查 是否有数据 openid = $openid
        $user_openid = DB::connection('mysql_shop')->table("user_wechat")->where(['openid'=>$openid])->first();
        if(!empty($user_openid)){
            //有数据 在网站有用户 user表有数据[ 登陆 ]
            $user_info = DB::connection('mysql_shop')->table("users")->where(['id'=>$user_openid->uid])->first();
            $request->session()->put('username',$user_info->name);
            header('Location:www.shops.com');
        }else{
            //没有数据 注册信息  insert user  user_openid   生成新用户
            DB::connection("mysql_shop")->beginTransaction();
            $user_result = DB::connection('mysql_shop')->table('users')->insertGetId([
                'password' => '',
                'name' => $wechat_user_info['nickname'],
                'reg_time' => time()
            ]);
            $openid_result = DB::connection('mysql_shop')->table('user_wechat')->insert([
                'uid'=>$user_result,
                'openid' => $openid,
            ]);
            DB::connection('mysql_shop')->commit();
            //登陆操作
            $user_info = DB::connection('mysql_shop')->table("users")->where(['id'=>$user_openid->uid])->first();
            $request->session()->put('username',$user_info['name']);
            header('Location:www.shops.com');
        }

    }


}
