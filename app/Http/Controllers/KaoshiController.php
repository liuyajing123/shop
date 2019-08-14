<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaoshiController extends Controller
{
    public function add()
    {
        return view('kaoshi1/add');
    }

    public function doadd(Request $request)
    {
        $data=$request->all();
        //dd($data);
        $res=DB::connection('mysql_shop')->table('guess')->insert($data);
        if($res){
            //return redirect('kaoshi1/index');
            echo json_encode(['msg'=>1]);
        }else{
            echo json_encode(['msg'=>2]);
        }
    }

    public function index()
    {
        $data=DB::connection('mysql_shop')->table('guess')->get();

        return view('kaoshi1/index', ['re' => $data]);
    }

    public function guess()
    {
        $id=$_GET['id'];
        $qw=DB::connection('mysql_shop')->table('quiz')->where('guess',$id)->first();
        if($qw){
            return view('kaoshi1/error');
        }else{
            $user = DB::connection('mysql_shop')->table('guess')->where('id',$id)->first();
            return view('kaoshi1/guess', ['re' => $user]);
        }
        
        
    }

    public function doguess(Request $request)
    {
        $data=$request->all();
        //dd($data);
        $date['guess']=$data['guess'];
        $date['quiz']=$data['quiz'];
        $res=DB::connection('mysql_shop')->table('quiz')->insert($date);
        if($res){
            return redirect('kaoshi1/index');
        }else{
            return redirect('kaoshi1/guess');
        }
    }

    public function goguess()
    {
        $id=$_GET['id'];
        $res = DB::connection('mysql_shop')->table('guess')->where('id', $id)->value('result');
        if($res){
            return view('kaoshi1/errors');
        }else{
            $user = DB::connection('mysql_shop')->table('guess')->where('id',$id)->first();
            return view('kaoshi1/goguess', ['re' => $user]);
        }
        
    }

    public function result(Request $request)
    {
        $data=$request->all();
        //dd($data);
        $date['result']=$data['result'];
        $date['id']=$data['id'];
        $res=DB::connection('mysql_shop')->table('guess')->where('id', $date['id'])->update(['result' => $date['result']]);
        if($res){
            return redirect('kaoshi1/index');
        }else{
            return redirect('kaoshi1/goguess');
        }
    }

    public function results()
    {
        $id=$_GET['id'];
        $re=DB::connection('mysql_shop')->table('guess')->join('quiz', 'guess.id', '=', 'quiz.guess')->where('id',$id)->first();
        if($re){
            return view('kaoshi1.loindex', ['user' => $re]);
        }else{
            return view('kaoshi1.errorss');
        };
        
    }
}
