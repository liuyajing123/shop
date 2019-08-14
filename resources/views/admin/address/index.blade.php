<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>列表</title>
</head>
<body>
    <table border="1">
        <tr>
            <td>姓名</td>
            <td>家庭地址</td>
            <td>操作</td>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{$v->name}}</td>
                <td>{{$v->province}}{{$v->city}}{{$v->district}}</td>
                <td>
                    <a href="{{url('admin/address/edit',['id'=>$v->id])}}">修改</a>
                    <a href="{{url('admin/address/delete',['id'=>$v->id])}}">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>