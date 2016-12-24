<?php
$return_code=0;
$return_msg="";
$return_data="";

try{
	
	include_once("db.config.php");
	include_once("admin.temporary.php");
}catch(Exception $e){
	$return_code=303;
	$return_msg="connection to database error";
}

//303 means error 306 means success 307 means admin access
if(isset($_POST['login_ok'])){
	$login_user=$_POST['username'];
	$login_pass=$_POST['password'];
	if(!$login_user){
		$return_code=303;
		$return_msg="Username is empty";
	}else if(!$login_pass){
		$return_code=303;
		$return_msg="Password is empty";
		
	}else if($login_user==$admin_user && $login_pass==$admin_pass){
		$return_code=307;
		$return_msg="admin authentication access";
	}else{
		$epass=md5($login_pass);
		
		$sql="SELECT * FROM cpa_acct WHERE username='".$login_user."' AND password='".$epass."'";
		$query=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($query) > 0){
			
			$tf=mysql_fetch_array($query);
			if($tf['is_activated'] ==NULL || $tf['is_activated'] ==0){
				$return_code=304;
				$return_msg="Activation is required";
			}else{
				$return_code=306;
				$return_msg="Login Success";
			}
			
		}else{
			
			
			$return_code=303;
			$return_msg="Username and Password not match";
		}
		
	}
	
	
}else{
	$return_code=303;
	$return_msg="No sent data received";
}

$arr=array("return_code"=>$return_code,"return_msg"=>$return_msg);
print json_encode($arr);

?>##