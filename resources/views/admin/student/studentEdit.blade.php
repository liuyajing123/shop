<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生修改</title>
</head>
<body>
@foreach($data as $v)
    <center>
        <form action="{{url('admin/student/update')}}" method="post">
        <input type="hidden" name="id" value="{{$v->id}}">
        姓名：<input type="text" name="name" value="{{$v->name}}">
        年龄：<input type="text" name="age" value="{{$v->age}}">
        性别:<input type="radio" name="sex" value="1" @if($v->sex == 1)checked @endif>男
             <input type="radio" name="sex" value="2" @if($v->sex == 2)checked @endif>女
        <input type="submit" value="修改">
        </form>
    </center>
@endforeach
</body>
</html>