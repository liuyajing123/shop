<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>调研问题</title>
    <script src="/jquery-3.3.1.js"></script>
</head>
<body>
<from action="{{url('admin/diaoyan/index')}}">
    调研问题：<input type="text" name="diaoyanwenti" id=""><br>
    问题选项：
    <select class="bb">
        <option value="请选择">请选择</option>
        <option value="单选">单选</option>
        <option value="多选">多选</option>
    </select><br>
              <input type="submit" value="添加问题">
</from>
<form action="{{url('admin/diaoyan/danxuan')}}" method="post">
@csrf
    <div class="radio">
        问题：<input type="text" name="title" id=""><br>
        <input type="radio" name="1">A<input type="text" name="aa"><br>
        <input type="radio" name="1">B<input type="text" name="bb"><br>
        <input type="radio" name="1">C<input type="text" name="cc"><br>
        <input type="radio" name="1">D<input type="text" name="dd"><br>
        <input type="submit" value="添加">
    </div>
</form>
<form action="{{url('admin/diaoyan/duoxuan')}}" method="post">
    @csrf
    <div class="checkbox">
        问题：<input type="text" name="title" id=""><br>
        <input type="checkbox">A<input type="text" name="a"><br>
        <input type="checkbox">B<input type="text" name="b"><br>
        <input type="checkbox">C<input type="text" name="c"><br>
        <input type="checkbox">D<input type="text" name="d"><br>
        <input type="submit" value="添加">
    </div>
</form>
</body>
</html>
<script>
    $(function(){
        $('.radio').hide();
        $('.checkbox').hide();
        $('.bb').click(function(){
            var name=$(this).val();
            if(name=='单选'){
                $('.radio').show();
                $('.checkbox').hide();
            };
            if(name=='多选'){
                $('.checkbox').show();
                $('.radio').hide();
            };
        });
    });
</script>