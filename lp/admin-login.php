<?php
//this is only for admin use 

include "admin_create.php";
if(isset($_POST['login'])){
	$login_user=$_POST['login_user'];
	$login_pass=$_POST['login_pass'];
	if($login_user !=$admin_username){
		$error="username is wrong";
	}else if($login_pass !=$admin_pass){
		$error="password is wrong";
	}else {
		setcookie("username",$login_user,time()+3600);
		
	header("Location:index.php");
	}
}
include "template/admin-login.html";




?>