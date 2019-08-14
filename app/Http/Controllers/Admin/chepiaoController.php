<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class chepiaoController extends Controller
{
    public function add()
    {
        return view("admin/chepiao/add");
    }

    public function do_add(Request $request)
    {
        $data=$request->except(['_token']);
        $res=DB::connection('mysql_shop')->table("chepiao")->insert([
            'checi'=>$data['checi'],
            'chufadi'=>$data['chufadi'],
            'daodadi'=>$data['daodadi'],
            'jiaqian'=>$data['jiaqian'],
            'zhangshu'=>$data['zhangshu'],
            'chufashijian'=>strtotime($data['chufashijian']),
            'daodashijian'=>strtotime($data['daodashijian']),
        ]);
        if ($res)
        {
            echo '添加成功';
            return redirect('admin/chepiao/index');
        }else{
            echo "<script>alert('添加失败!');history.back();</script>";

        }
    }

    public function index(Request $request)
    {

        $chufadi = $request->get('chufadi');//接收到的出发地
        $daodadi = $request->get('daodadi');//接收到的到达地
        $where = [];
        if (!empty($chufadi)) {
            $where[] = ['chufadi', 'like', '%' . $chufadi . '%'];
        }
        if (!empty($daodadi)) {
            $where[] = ['daodadi', 'like', '%' . $daodadi . '%'];
        }
        $data = DB::connection('mysql_shop')->table('chepiao')
            ->where($where)
            ->orderBy('id', 'desc')
            ->paginate(2);

        return view('admin/chepiao/index',['data'=>$data,'chufadi'=>$chufadi,'daodadi'=>$daodadi]);
    }
}
