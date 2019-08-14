<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>三级联动添加</title>
</head>
<body>
<form action="{{url('admin/address/do_add')}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>姓名：</td>
            <td><input type="text" name="name" id="s"></td>
        </tr>
        <tr>
            <td>家庭地址：</td>
            <td>
                <select class="jj" name="province">
                    <option value="0" selected="selected">请选择...</option>
                </select>
                <select class="jj" name="city">
                    <option value="0" selected="selected">请选择...</option>
                </select>
                <select class="jj" name="district">
                    <option value="0" selected="selected">请选择...</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
<script>
    jQuery('select').change(function(){
        // alert(123);
        var parent_id=jQuery(this).val();
        var obj=jQuery(this);
        if(!parent_id){
            return;
        }
        var str='<option value="0">请选择...</option>';
        jQuery.post("{:url('Order/getSonAddress')}",{parent_id:parent_id},function(data){
            if(data.code!='00000'){
                alert(data.msg);
                return;
            }
            jQuery.each(data.data,function(i,val){
                str+='<option value="'+val.region_id+'">'+val.region_name+'</option>';
            });
            obj.next().html(str);
        },'json');
    });
</script>
</body>
</html>