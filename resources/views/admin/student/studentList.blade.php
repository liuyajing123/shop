<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('admin/student/index')}}">
<input type="text" name="name1" id="" value="{{$name1}}">
<input type="submit" value="搜索">
</form>
</center>

<center>
    <table border="1">
            <h1>学生列表</h1>
            <tr>
                <td>id</td>
                <td>姓名</td>
                <td>性别</td>
                <td>年龄</td>
                <td>操作</td>
            </tr>
            @foreach($student as $item)
            <tr>
                <td>{{ $item->id}}</td>
                <td>{{ $item->name}}</td>
                <td>{{ $item->sex}}</td>
                <td>{{ $item->age}}</td>
                <td>
                <a href="{{url('admin/student/edit',['id'=>$item->id])}}">修改</a>
                <a href="{{url('admin/student/delete',['id'=>$item->id])}}">删除</a>
                </td>
            </tr>
            @endforeach
    </table>
    {{ $student->appends(['name1' => $name1])->links() }}
</center>
</body>
</html>