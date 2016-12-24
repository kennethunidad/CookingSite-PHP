<?php
if(isset($_GET['logout'])){
	
	//this will remove session cookie and redirect to homepage
	setcookie("username",$_COOKIE['username'],time()-3600);
	
	header("Location:index.php");
}
//start of set time, needs to know when the recipe posted , and also the comments
$time=getdate();

$time['ampm']="Am";
if($time['seconds'] < 10){
	$time['seconds']="0".$time['seconds'];
	
}
if($time['minutes'] < 10){
	$time['minutes'] ="0".$time['minutes'];
}
if($time['hours'] < 12){
	$time['ampm']="Am";
}else{
	$time['ampm']="Pm";
	$time['hours'] =$time['hours']-12;
}
if($time['hours'] < 10){
	$time['hours']="0".$time['hours'];
}
$cats=array("Dessert","Tid Bits","Chicken","Pork&Beef");
$date_published=$time['month']." ".$time['mday'].", ".$time['year']." at ".$time['hours']." : ".$time['minutes']." ".$time['ampm'];
if(isset($_GET['add_recipe']) || isset($_GET['update_recipe'])){
	//this will be the page for adding recipe , but only admin can be able to view
	
	
	if(!$_COOKIE['username']){
		//if admin is not yet logged in , the page will not display and redirects you to homepage
		
		header("Location:index.php");
	}else{
		//if admin is logged in , the page will display
		if(isset($_POST['add_recipe']) || isset($_POST['update_recipe'])){
			$blog_text=$_POST['blog_text'];
			$blog_title=trim($_POST['blog_title']);
		    $recipe_cat=$_POST['recipe_cat'];
			$files=$_FILES['recipe_img'];
			if(strlen($blog_title) < 4){
				$error="Recipe name is too short";
			}else if($recipe_cat=="none"){
					$error="Please choose a recipe category";
					
			
			}else if(strlen($blog_text) < 50){
				$error="Recipe content is too short, minimum is 50 characters";
			
			    
			
			}else{
				$file_error=0;
				$move_file=0;
				if(strlen($files['name']) > 1){
					if($files['type'] =="image/jpeg" || $files['type']=="image/jpg" || $files['type']=="image/png"){
						$move_file=1;
					}else{
						$file_error=1;
						$error="Please choose an image file (.jpg or .png)";
					}
				}
				if($file_error==0){
					$ntext=str_replace(" ","",$blog_title);
					if(!ctype_alnum($ntext)){
						$error="Recipe name must not contain any special characters";
					}else{
						$sql="SELECT * FROM recipe WHERE date_published='".$date_published."'";
						$query=mysql_query($sql) or die(mysql_error());
						if(mysql_num_rows($query) > 0){
							$error="You already submitted this in less than a minute";
						}else{
							$image_name="";
						if($move_file==1){
							
							
							$image_name="recipe".rand(1000000,9999999);
							if($files['type']=="image/jpeg" || $files['type']=="image/jpg"){
								//the image file only accepts jpeg and png file only
								$image_name=$image_name.".jpg";
							}else if($files['type']=="image/png"){
								$image_name==$image_name.".png";
							}
							
							//the file will move to the folder /images/upload
							move_uploaded_file($files['tmp_name'],"../images/upload/".$image_name) or die("cant upload file");
						}
					    if(isset($_GET['update_recipe'])){
							include "inc/update.delete.php";
							print_r(updateRecipe($blog_title,addslashes($blog_text),$image_name,$recipe_cat,$_GET['update_recipe']));
							
					header("Location:index.php?blog_id=".$_GET['update_recipe']);
						}else{
							$blog_id=rand(1000000000,9999999999);
							$sql="INSERT INTO recipe (author_name,date_published,blog_id,blog_title,blog_content,category,blog_img) VALUES ('".$_COOKIE['username']."','".$date_published."','".$blog_id."','".$blog_title."','".addslashes($blog_text)."','".$recipe_cat."','".$image_name."')";
						
							mysql_query($sql) or die(mysql_error());
							header("Location:index.php?blog_id=".$blog_id);
						}
						}
					}
				}
			}
		}
		
	}
}

if(isset($_GET['recipe_id'])){
	//this will be the page for recipe ,
	
	$blog_id=$_GET['recipe_id'];
	if(!$blog_id){
		header("Location:index.php");
	}else{
		$sql="SELECT * FROM recipe WHERE blog_id='".$blog_id."'";
		$query=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($query)==0){
			header("Location:index.php");
		}
		
		
		
		if(isset($_POST['post_comment'])){
			// check if theres an response id
			$parent_id=$_POST['parent_id'];
			if(!$parent_id){
				$parent_id=0;
			}
			if($parent_id !=0){
				$sql="SELECT * FROM comment WHERE post_id='".$parent_id."'";
				$query=mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($query) ==0){
					$parent_id=0;
				}
				
			}
			
			$comment=$_POST['reply_comment'];
			$name=$_POST['reply_name'];
			$email=$_POST['reply_email'];
			$error="";
			$web=$_POST['reply_website'];
			$blog_id=$_GET['recipe_id'];
			if(strlen(trim($comment)) < 6){
				$error="Very short Comment";
			}else if(strlen($name) < 6){
				$error="Very short name";
			}else if(!ctype_alnum(str_replace(" ","",$name))){
				$error="Name must not contain special characters";
			
			}else{
				if(strlen(trim($email)) > 0){
					if(!filter_var(trim($email),FILTER_VALIDATE_EMAIL)){
						$error="Invalid email format";
					}
				}
				if(strlen(trim($web)) > 0){
					$web=trim($web);
				}
				
				if($error==""){
					$post_id=rand(1000000000,9999999999);
					$sql="INSERT INTO comment (name,post_id,post_text,email,website_url,date_posted,blog_id,parent_id) VALUES ('".$name."','".$post_id."','".addslashes($comment)."','".trim($email)."','".$web."','".$date_published."','".$blog_id."','".$parent_id."')";
					mysql_query($sql) or die(mysql_error());
				}
			}
			
			
		}
	}	
}

?>