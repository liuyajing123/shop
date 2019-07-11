<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class goodsController extends Controller
{


    public  function add()
    {
        return view("admin/goods/add");
    }
    public function do_add(Request $request)
    {
        $data=$request->except(['_token']);
//        dd($data);
        $path=$request->file('goods_picture')->store('/goods/goods_picture');
//        dd($path);
        $path_url=asset('storage/'.$path);
        $data['goods_picture']=$path_url;
        $data['add_time']=time();
        $res=DB::connection('mysql_shop')->table('goods')->insert($data);
        if ($res)
        {
            echo 111;
//            return redirect('admin/goods/index');
        }else{
            echo "no_add";
        }
    }

}
