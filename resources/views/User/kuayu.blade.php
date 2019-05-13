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
<input type="text" id="name">
<input type="button" id="button">
</body>
</html>
<script src="./js/jquery.js"></script>

<script>
   $("#button").click(function(){
//       alert(111);
       var data={};
      var name=$("#name").val();
      data.name=name;
      $.ajax({
          type:"get",
          data:data,
          url:"http://vm.two.api.com/kuayuDo",
          data:data,
          dataType:"jsonp",
          jsonp:"callback",
          success:function(msg){

          }
      })

   })
</script>
