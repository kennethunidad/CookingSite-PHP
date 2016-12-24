<?php


function archiveList(){
	include_once("inc/db.config.php");
	$sql="SELECT date_published FROM recipe ORDER BY date_published ";
	$query=mysql_query($sql) or die(mysql_error());
	$arr=array("January"=>array(),"February"=>array(),"March"=>array(),"April"=>array(),"May"=>array(),"June"=>array(),"July"=>array(),"August"=>array(),"September"=>array(),"October"=>array(),"November"=>array(),"December"=>array());
	if(mysql_num_rows($query) > 0){
		$i=0; 
		while($tf=mysql_fetch_array($query)){
				$date_published=$tf['date_published'];
				$keys=array_keys($arr);
				foreach($keys as $key){
					if(substr_count($date_published,$key) > 0){
						$arr2=explode(" ",$date_published);
						$yr=$arr2[2];
						
						try{
							$arr[$key][$yr]++;
						}catch(Exception $e){
							$arr[$key][$yr]=1;
							
						}
						
					}
				}
		
		}
		
	}
	return $arr;
}

function postCountedWords($paragraph,$num){
	$paragraph=str_replace("\r\n"," ",$paragraph);
	$paragraph=str_replace("\n"," ",$paragraph);
	$word=explode(" ",$paragraph);
	if(count($word) > $num){
		$pars="";
		for($i=0; $i < $num; $i++){
			if($i==0){
				$pars=$word[$i];
			}else{
				$pars=$pars." ".$word[$i];
			}
		}
		return $pars;
	}else{
		return $paragraph;
	}
	
}
?>