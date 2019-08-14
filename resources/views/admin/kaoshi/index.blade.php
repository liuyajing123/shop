<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言添加 展示</title>
</head>
<body>
<form action="{{url('admin/kaoshi/do_add')}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>留言：</td>
            <td><textarea name="liuyan" id="" cols="30" rows="10"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
<form action="{{url('admin/kaoshi/index')}}">
    留言内容：<input type="text" name="name1" id="" value="{{$name1}}">
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>id</td>
        <td>留言内容</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->liuyan}}</td>
        <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
        <td>
            <a href="{{url('admin/kaoshi/delete',['id'=>$v->id])}}">删除</a>
        </td>
    </tr>
    @endforeach
</table>
{{ $data->appends(['name1' => $name1])->links() }}
</body>
</html>