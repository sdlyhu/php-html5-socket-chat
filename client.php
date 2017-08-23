<!DOCTYPE html>
<html>
<head>
    <title>websocket通讯系统</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<div style="width: 900px;height: 500px;margin: 30px auto;text-align: center">
    <h1>websocket通讯系统</h1>
    <div class="main" style="margin: 10px;">
        <div style="float:right;width: 40%; min-height: 400px;">
            <div style="display: inline-block;margin: 10px;">给自己起一昵称<input type="text" id="name" name="name"></div>
            <textarea id="msg" rows="6" cols="50"></textarea><br>
            <input type="button" value="发送消息" onclick="send()">
        </div>
        <div id="list" style=" float:left; width: 55%;border:  1px solid gray; min-height: 400px; margin: 10px auto;"></div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    if (window.WebSocket){
        console.log("本浏览器支持websocket");
    } else {
        console.log("本浏览器不支持websocket");
    }
    //实例化websocket
    var ws = new WebSocket("ws://127.0.0.1:8000");
    //连接websocket
    ws.onopen = function(){
        console.log('连接成功');
//        var data="系统消息：可以开始聊天了";
        var box=document.getElementById("list");
        var p=document.createElement("p");
        p.innerHTML='系统消息：可以开始聊天了';
        box.appendChild(p)
        ws.send('');
    }
    //向list中追加消息
    ws.onmessage = function(e){
        var obj=eval("("+e.data+")");
        list(obj.mess);
    }
    //输出错误
    ws.onerror = function(){
        var data="出错了，请退出重试";
        list(data);
    }
    //发送消息
    function send()
    {
        var data_msg=document.getElementById("msg").value;
        data_msg = escape(data_msg);
        var data_name=document.getElementById("name").value;
        var data_send = new Array();
        data_send.push(data_name);
        data_send.push(data_msg);
        ws.send(data_send);
    }
    //把消息罗列的#list的div中
    function list(data)
    {
        var p=document.createElement("p");
        var left_span=document.createElement("span");
        var right_span=document.createElement("span");
        left_span.setAttribute('class','left-span');
        var center_span=document.createElement("span");
        left_span.style.color= randomRgbaColor();
        left_span.innerHTML=data.match(/(\S*),/)[1];
        right_span.innerHTML=unescape(data.match(/,(\S*)/)[1]);
        center_span.innerHTML=':';
        p.appendChild(left_span);
        p.appendChild(center_span);
        p.appendChild(right_span);
        var box=document.getElementById("list");
        box.appendChild(p);
    }

    function randomRgbaColor() { //随机生成RGBA颜色
        var r = Math.floor(Math.random() * 256); //随机生成256以内r值
        var g = Math.floor(Math.random() * 256); //随机生成256以内g值
        var b = Math.floor(Math.random() * 256); //随机生成256以内b值
        var alpha = Math.random(); //随机生成1以内a值
        return `rgb(${r},${g},${b},${alpha})`; //返回rgba(r,g,b,a)格式颜色
    }


</script>