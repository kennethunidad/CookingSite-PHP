<hr/>
<div id='blog_wrapper'>
<form action='index.php' method='get'>

<input type='text' name='search' placeholder='Search..' id='blog_input' class='search' style='border-radius:10px 0px 0px 10px;'/>
<button type='submit' name='submit_search' id='blog_button' class='button_search' style='background:rgb(0,175,175);border-radius:0px 10px 10px 0px;'>Search</button>
</form>
<div id='blog_foot' class='foot'></div>
</div>
<br/><br/><br/>
<hr/>
<font id='label_title'>RECENT POSTS</font><br/>
<ul>
<?php
$sql="SELECT * FROM recipe ORDER BY id DESC LIMIT 10";
$query=mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($query) > 0){
	while($tf=mysql_fetch_array($query)){
echo "<li><a href='index.php?recipe_id=".$tf['blog_id']."' id='blog_link' >".$tf['blog_title']."</a></li>";
	}
}else{
		echo "<li>No recent Post </li>";
}
?>


</ul>
<hr/>
<font id='label_title'>RECENT COMMENTS</font>
<ul>

<?php
$sql="SELECT * FROM comment ORDER BY id DESC LIMIT 10";
$query=mysql_query($sql ) or die(mysql_error());
if(mysql_num_rows($query) > 0){
	while($tf=mysql_fetch_array($query)){
		$sql="SELECT blog_title FROM recipe WHERE blog_id='".$tf['blog_id']."'";
		$nquery=mysql_query($sql) or die(mysql_error());
		$df=mysql_fetch_array($nquery);
		echo "<li><a href='".$tf['website_url']."' id='blog_link' >".$tf['name']."</a> on <a href='index.php?recipe_id=".$tf['blog_id']."#".$tf['post_id']."' id='blog_link'>".$df['blog_title']."</a></li>";
	}
	
}else{
	echo "<li>No Recent Comments</li>";
} 

?>


</ul>

<hr/>

<font id='label_title'>ARCHIVES</font>
<?php
$arrs=archiveList();
?>
<ul>
<?php
$keys=array_keys($arrs);
$i=0;
foreach($keys as $key){
	$month=$arrs[$key];
	if(count($month) > 0){
		$yr=array_keys($month);
		foreach($yr as $year){
			echo "<li><a href='index.php?archivesAt=".$key."/".$year."' id='blog_link'>".$key." ".$year."</a> (".$month[$year].")</li>";
		}
		$i++;
	}
}
if($i == 0){
	echo "<li>No archives</li>";
}
?>

</ul>
