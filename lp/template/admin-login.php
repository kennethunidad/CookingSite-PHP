<html>
<head>
<title>Lutongbahay > Log In</title>

</head>
<style>
body{
 background:#E8E8E8;
 background-image:url("template/img/background.jpg");
 background-repeat:repeat-x;

 padding:0px;
}
#wrapper{
width:600px;
margin:auto;
padding:50px;
}
#login_wrapper{
width:250px;
background:#FFFFFF;
padding:20px;
margin-top:100px;
text-align:left;
box-shadow:2px 2px 2px 2px #888888;
}
#login_label{
color:#888888;
}
#login_input{
width:100%;
height:35px;

border:1px solid #d8d8d8;
}

#login_button{
border:0px;
background:blue;
padding:10px;
box-shadow: 1px 1px 1px 1px #888888;
border-radius:2px 2px 2px 2px;
color:#FFFFFF;
font-size:15px;
}
#login_button:hover{
background:#00DDFF;
}


</style>

<body>
<img src="" style="position:relative; top:-10"/>
<center>

<div id='wrapper'>

<div id='login_wrapper'>
<?php echo $error; ?><br/>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<font id='login_label'>Username</font><br/>

<input type='text' name='login_user' id='login_input' /><br/>
<br/>
<font id='login_label'>Password</font><br/>
<input type='password' name='login_pass' id='login_input'/><br/>
<br/>
<p align='right'><button type='submit' name='login' id='login_button'>Log In</button></p></form>
</div>

</div>

</div>
</center>
</body>
</html>