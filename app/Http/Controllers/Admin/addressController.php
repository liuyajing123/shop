<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class addressController extends Controller
{
    public function add()
    {

        return view('admin/address/add');
    }
    public function do_add(Request $request)
    {

        $data = $request->except(['_token']);
//        dd($data);
        $res = DB::connection('mysql_shop')->table('address')->insert($data);
        if($res){
            return redirect('admin/address/index');
        }else{
            echo "添加失败";
        }
    }

    public function index()
    {
        $data = DB::connection('mysql_shop')->table('address')->get();
        return view('admin/address/index',['data'=>$data]);
    }
}
