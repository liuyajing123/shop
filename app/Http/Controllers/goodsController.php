<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class goodsController extends Controller
{
    public function add()
    {
        return view('admin/zhoulao/add');
    }

    public function do_add(Request $request)
    {
        $data = $request->except(['_token']);
//        dd($data);
        $path=$request->file('goods_picture')->store('/goods/goods_picture');
//        dd($path);
        $path_url='storage/'.$path;
        $data['goods_picture']=$path_url;
        $data['add_time']=time();
        $res = DB::connection('mysql_shop')->table('goods')->insert($data);
        if($res){
            return redirect('goods/index');
        }else{
            echo "添加失败";
        }
    }

    public function index(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');
        $num = $redis->get('num');
        echo "访问次数：".$num;
        $name1 = $request->get('name1');
        $search = "";
//         dd($name1);
        if(!empty($name1)){
            $info = DB::connection('mysql_shop')->table('goods')->where('goods_name','like','%'.$name1.'%')->paginate(2);
        }else{
            $info = DB::connection('mysql_shop')->table("goods")->paginate(2);
        }

        return view('admin/zhoulao/index',['data'=>$info,'name1'=>$name1]);
    }
    public function edit($id)
    {
        $data = DB::connection('mysql_shop')->table('goods')->where('id','=',$id)->select()->get();
        return view("admin/zhoulao/edit",['data'=>$data]);
    }

    public function update(Request $request)
    {
        /*dd($data);*/
//        dd($data);
//        echo 11;die;
        $id=$request->id;
//        dd($id);
        $data=$request->except(['_token','id']);
        $data['add_time']=time();
//        dd($data);
//        dd($data['goods_img']);
//        dd($request->file('goods_img'));
        if($request->file('goods_picture')=='')
        {
            $path=$request->file('goods_picture')->store('/goods/goods_picture');
            $path_url='storage/'.$path;
            $data['goods_picture']=$path_url;
//        dd($data);
            $res=DB::connection('mysql_shop')->table('goods')->where(['id'=>$id])->update([
                'goods_name'=>$data['goods_name'],
                'goods_number'=>$data['goods_number'],
                'goods_price'=>$data['goods_price'],
                'goods_picture'=>$data['goods_picture'],
                'add_time'=>$data['add_time'],
            ]);
            if ($res){
                return redirect('goods/index');
            }
        }else{
            $path=$request->file('goods_picture')->store('/goods/goods_picture');
            $path_url='storage/'.$path;
            $data['goods_picture']=$path_url;

//        dd($data);
            $res=DB::connection('mysql_shop')->table('goods')->where(['id'=>$id])->update([
                'goods_name'=>$data['goods_name'],
                'goods_number'=>$data['goods_number'],
                'goods_price'=>$data['goods_price'],
                'goods_picture'=>$data['goods_picture'],
                'add_time'=>$data['add_time'],
            ]);
            if ($res){
                return redirect('goods/index');
            }else{
                echo "修改失败";
            }
        }

    }

    public function delete($id)
    {
        $res = DB::connection('mysql_shop')->table('goods')->where('id',$id)->delete();
        if($res){
            return redirect('goods/index');
        }else{
            echo "删除失败";
        }
    }
}
