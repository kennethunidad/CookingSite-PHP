<?php

function updateRecipe($title,$content,$img,$category,$recipe_id){
	include "inc/db.config.php";
	$arr=array();
	if(strlen($img) > 1){
		$sql="UPDATE recipe SET blog_title='".$title."',blog_content='".$content."',blog_img='".$img."',category='".$category."' WHERE blog_id='".$recipe_id."'";

		
	}else{
		$sql="UPDATE recipe SET blog_title='".$title."',blog_content='".$content."',category='".$category."' WHERE blog_id='".$recipe_id."'";

	}
		
	if(!mysql_query($sql)){
		$arr=array("error"=>1,"msg"=>"unable to update:".mysql_error());
		
	}else{
		$arr=array("error"=>0,"msg"=>"update successful");
		
	}
	return $arr;
}
function deleteRecipe($recipe_id){
	include "../inc/db.config.php";
	
	$sql="DELETE FROM recipe WHERE blog_id='".$recipe_id."'";
	$sql2="DELETE FROM comment WHERE blog_id='".$recipe_id."'";
	if(!mysql_query($sql2)){
		$arr=array("error"=>1,"msg"=>"unable to delete:".mysql_error());
	}else{
		if(!mysql_query($sql)){
			$arr=array("error"=>1,"msg"=>"unable to delete:".mysql_error());
		}else{
			$arr=array("error"=>0,"msg"=>"delete successful");
		}
	}
	return $arr;
	
	
}
function deleteComment($post,$parent){
	include "../inc/db.config.php";
	
	$sql="DELETE FROM comment WHERE parent_id='".$parent."' AND post_id='".$post."'";
	if(!mysql_query($sql)){
		$arr=array("error"=>1,"msg"=>"unable to delete:".mysql_error());
		
	}else{
		if($parent == 0){
			$sql2="DELETE FROM comment WHERE parent_id='".$post_id."'";
			if(!mysql_query($sql2)){
				$arr=array("error"=>1,"msg"=>"unable to delete:".mysql_error());
				
			}else{
				$arr=array("error"=>0,"msg"=>"Delete successful");
			}
		}else{
				$arr=array("error"=>0,"msg"=>"Delete successful");
		}
		
	}
	
	return $arr;
	
}
if(isset($_GET['delete_comment']) && isset($_GET['delete_from'])){
	
	print json_encode(deleteComment($_GET['delete_comment'],$_GET['delete_from']));
}

if(isset($_GET['delete_id'])){
	
	print json_encode(deleteRecipe($_GET['delete_id']));
}

?>