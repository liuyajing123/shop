@extends('layout.common')
@section('title','登录')
@section('body')
    <center>
        <h1>登录</h1>
        <form action="{{url('Student/do_login')}}" method="post">
            @csrf
            用户名：<input type="text" name="name" id="">
            密码：<input type="password" name="password" id="">
            <input type="submit" value="提交">
        </form>
    </center>
@endsection
@section('script')
<script>
    $(function(){

    });
</script>
@endsection