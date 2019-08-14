<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class kaoshiController extends Controller
{
    public function login()
    {
        return view('admin/kaoshi/login');
    }
    public function do_login(Request $request)
    {
        $data=$request->all();
        $info=DB::connection('mysql_shop')->table('admin')->insert([
            'name'=>$data['name'],
            'pwd'=>($data['pwd']),
        ]);
        if($info){
            return redirect('admin/kaoshi/index');
        }
    }
    public function index(Request $request)
    {
        $redis = new \Redis();
        $redis -> connect('127.0.0.1','6379');
        $redis ->incr('number');
        $num = $redis-> get('number');
        echo "访问次数:".$num;
        $name1 = $request->get('name1');
        $search = "";
//         dd($name1);
        if(!empty($name1)){
            $data = DB::connection('mysql_shop')->table('liuyan')->where('liuyan','like','%'.$name1.'%')->paginate(3);
        }else{
            $data = DB::connection('mysql_shop')->table("liuyan")->paginate(3);
        }
        return view('admin/kaoshi/index',['data'=>$data,'name1'=>$name1]);
    }

    public function do_add(Request $request)
    {
        $data = $request->except(['_token']);
//        dd($data);
        $data['addtime']=time();
        $res = DB::connection('mysql_shop')->table('liuyan')->insert($data);
        if($res){
            return redirect('admin/kaoshi/index');
        }else{
            echo "添加失败";
        }
    }
    public function delete($id)
    {
        $res = DB::connection('mysql_shop')->table('liuyan')->where('id',$id)->delete();
        if($res){
            return redirect('admin/kaoshi/index');
        }else{
            echo "删除失败";
        }
    }
}
