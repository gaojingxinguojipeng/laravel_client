<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table border=1>
    <tr>
        <td>企业名称</td>
        <td>税务号</td>
        <td>对公账号</td>
        <td>营业执照</td>
        <td>APPID</td>
        <td>key</td>
        <td>审核状态</td>
        <td>是否通过</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr id="{{$v->id}}">

        <td class="name">{{$v->name}}</td>
        <td class="shui">{{$v->shui}}</td>
        <td>{{$v->dui}}</td>
        <td></td>
        <td>{{$v->APPID}}</td>
        <td>{{$v->key}}</td>
        @if($v->status==1)
        <td>未通过</td>
        @elseif($v->status==2)
        <td>以通过</td>
        @endif
        <td><input type="button" class="button" value="通过" ></td>
    </tr>
     @endforeach
</table>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".button").click(function () {
            var kk = $(this);
            var id=kk.parents('tr').attr('id');
            var data={};
            data.id=id;
            var url="http://laravel.lzy1109.com/regstatus";
            $.ajax({
                type: "post",
                data:data,
                dataType: "json",
                url: url,
                success: function (msg) {
                    if(msg.code==1){
                        alert(msg.msg);
                    }
                }
            })
        })
    })
</script>