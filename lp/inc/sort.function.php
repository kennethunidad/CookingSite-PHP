<?php

function listAlphabet(){
	include "inc/db.config.php";
	$alphs=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

	$ars=array();
	for($i=0; $i < count($alphs); $i++){
		$sql="SELECT blog_title FROM recipe WHERE blog_title LIKE '".$alphs[$i]."%'";
		$query=mysql_query($sql) or die(mysql_error());
		$count= mysql_num_rows($query);
		if($count > 0 ){
			array_push($ars,$alphs[$i]);
			
		}
		
		
	}
	
	return $ars;
	
	
}







?>