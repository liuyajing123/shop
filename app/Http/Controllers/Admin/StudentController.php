<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
class StudentController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function do_login(Request $request)
    {
        $data = $request->all();
        $request->session()->put('username','name123');
        return redirect('/Student/index');
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
        // dd($name1);
        if(!empty($name1)){
            $info = DB::table('student')->where('name','like','%'.$name1.'%')->paginate(2);
        }else{
            $info = DB::table("student")->paginate(2);
        }
       
        return view('admin/student/studentList',['student'=>$info,'name1'=>$name1]);
    }
    public function add()
    {
        return view('admin/student/studentAdd',[]);
    }
    public function do_add(Request $request)
    {
        $data = $request->except(['_token']);
        // dd($data);
        $validatedData = $request->validate([
            'name' => 'required|unique:student|max:3',
            'sex' => 'required',
            'age' => 'required',
        ],[
            'name.required'=>'学生姓名必填',
            'name.unique'=>'学生姓名已存在',
            'name.max'=>'学生姓名长度不能超过三个字符',
            'sex.required'=>'学生性别必选',
            'age.required'=>'学生年龄必填',
        ]);
        $res = DB::table('student')->insert($data);
        if($res){
            return redirect('admin/student/index');
        }else{
            echo "添加失败";
        }
    }
    public function edit($id)
    {
        $data = DB::table('student')->where('id','=',$id)->select()->get();
        return view('admin/student/studentEdit',['data'=>$data]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);
        $id=$request->get('id');
        // dd($id);
        $res = DB::table('student')->where('id',$id)->update($data);
        if($res){
            return redirect('admin/student/index');
        }else{
            echo "修改失败";
        }
    }
    public function delete($id)
    {
        $res = DB::table('student')->where('id',$id)->delete();
        if($res){
            return redirect('admin/student/index');
        }else{
            echo "删除失败";
        }
    }
}
