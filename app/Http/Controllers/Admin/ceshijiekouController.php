<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ceshijiekouController extends Controller
{
    public function ceshijiekou(Request $request)
    {
        if(empty($request->all()['access_token'])||$request->all()['access_token']!='ACCESS_TOKEN')
        {
            return json_encode(['errno'=>'40014']);
        }
        $info =DB::connection('mysql_shop')->table('liuyan')->get()->toArray();
        $info=json_decode(json_encode($info),1);
        echo json_encode($info);


    }
}
