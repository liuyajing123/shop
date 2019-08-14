<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生添加</title>
</head>
<body>
    <center>
        <form method="post" action="{{url('admin/student/do_add')}}" >
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        姓名：<input type="text" name="name" id="">
        年龄：<input type="text" name="age" id="">
        性别：<input type="radio" name="sex" id="" value="男">男
             <input type="radio" name="sex" id="" value="女">女
        <input type="submit" value="提交">
        </form>
    </center>
</body>
</html>