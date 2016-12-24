
<script>
$(document).ready(function(){
$(".reply_link").click(function(){
	var parent=$(this);
	var parent_id=parent.attr("parent_id");
	$("input[name=parent_id]").val(parent_id+"");
});
});


</script>
<style>
.admin_button{
	width:100%;
	border-radius:5px;
	
}

</style>
<script>
function deleteConfirm(id){
	var res=confirm("are you sure you want to delete this recipe?");
	if(res){

		$.getJSON("http://localhost/lutongpinoy/lp/inc/update.delete.php?delete_id="+id,function(data){
			if(data.error==0){
				window.location="http://localhost/lutongpinoy/";
				alert(data.msg);
			}else{
				alert(data.msg);
			}
			
		});
		
	}
	
}
function deleteComment(post_id,parent_id){
	var res=confirm("are you sure you want to delete this comment?");
	if(res){

		$.getJSON("http://localhost/lutongpinoy/lp/inc/update.delete.php?delete_comment="+post_id+"&delete_from="+parent_id,function(data){
			if(data.error==0){
				
				alert(data.msg);
				location.reload();
			}else{
				alert(data.msg);
			}
			
		});
		
	}
	
}
</script>

<?php
include "inc/sort.function.php";
$a2z=listAlphabet();
echo "<div id='page_container' style='text-align:left;margin-left:10px;'>";
echo "SORT:";
for($i =0; $i < count($a2z); $i++){
	
	echo "<div id='page_number'>";
	echo "<a href='index.php?sort=".$a2z[$i]."' id='alphabet'>".$a2z[$i]."</a>";
	echo "</div>";
}
echo "</div>";
if(isset($_GET['add_recipe']) || isset($_GET['update_recipe'])){
	
	// it includes the creating recipe page
	include "template/create_blog.html";
}else if(isset($_GET['loc'])){
	if($_GET['loc']=="aboutus"){
		//includes the aboutus page 
		include "template/aboutus.html";
	}
	
}else {
$arc=$_GET['archivesAt'];
$catf=$_GET['category'];
$page=$_GET['page'];
$search=$_GET['search'];
$sorts=$_GET['sort'];
$look="";
if(isset($arc)){
	if(!$arc){
	
	}else{
		$lk=explode("/",$arc);
		if(count($lk) == 2){
			$look="WHERE date_published LIKE '".$lk[0]."%' AND date_published LIKE '%".$lk[1]."%'"; 
			
		}
	}
}else if(isset($_GET['recipe_id'])){
	$look="WHERE blog_id='".$_GET['recipe_id']."'";
	
}else if(isset($catf)){
	$excatf=explode(" ",$catf);
	$look="WHERE category LIKE '%".$excatf[0]."%'";
	
}else if(isset($search)){
	
	
	$look="WHERE blog_title LIKE '%".$search."%'";
}else if(isset($sorts)){
	$look="WHERE blog_title LIKE '".$sorts."%'";
}	

$start=0;
$limit=10;


$csql="SELECT * FROM recipe ".$look;
$cquery=mysql_query($csql) or die(mysql_error());
$num=mysql_num_rows($cquery);
$total=ceil($num/$limit);
if($num > $limit){
	if(!$page || $page==0 || !ctype_digit($page)){
	
		$page=1;
	
	}else{
		$start=$limit*($page-1);
	}
}


$sql="SELECT * FROM recipe ".$look." ORDER BY blog_title ASC LIMIT ".$limit." OFFSET ".$start;

$query=mysql_query($sql) or die(mysql_error());

$num_row=mysql_num_rows($query);
$current_blog="";
if($num_row > 0){
	while($tf=mysql_fetch_array($query)){
		echo "<div id='blog_content'>";
		$current_blog=$tf['blog_title'];
		echo "<div id='blog_head' class='title'><a href='index.php?recipe_id=".$tf['blog_id']."' id='blog_link' class='main_link'> ".$tf['blog_title']."</a></div>";
		echo "<div id='blog_info' class='info' align='center'>";
		
			echo "<img src='../images/upload/".$tf['blog_img']."' alt='".$tf['blog_title']."' width='90%' heigth='90%'/><br/>";
		
		
		echo "<br/>".$tf['date_published']."<br/>";
		if(isset($_COOKIE['username']) && isset($_GET['recipe_id'])){
			echo "<p align='left'>";
			echo "<a href='index.php?update_recipe=".$_GET['recipe_id']."'><button name='update' id='blog_button' class='admin_button'>EDIT</button></a><br/><br/>";
			echo "<input type='button' name='".$_GET['recipe_id']."' value='DELETE' id='blog_button' class='admin_button' onclick='deleteConfirm(".$_GET['recipe_id'].")'/><br/>";
			echo "</p>";
		}
		
		echo "</div>";
        echo  "<div id='blog_desc' class='desc'>";
		if(isset($_GET['recipe_id'])){
			echo str_replace("\n","<br/>",$tf['blog_content']);
		}else{
			echo postCountedWords(strip_tags($tf['blog_content']),30).".....";
		}
		echo " </div>";
		echo "<div id='blog_foot' class='foot'></div>";
		echo "</div>";
	}
}
}

if($num_row > 0){
 
	$suffix=$_SERVER['PHP_SELF']."?page=";
	if(isset($arc)){
		$suffix=$_SERVER['PHP_SELF']."?".$arc."&amp;page=";
		
	}
	if($total > 1){
		
		echo "<div id='page_container'>";
		echo "PAGE : ".$page."/".$total."<br/>";
		if($page >1){
			 echo "<a href='".$suffix.($page-1)."'>";
		}
         
		 
		 echo "<div id='page_number'>&lt;&lt;</div>";
		 if($page > 1){
			  echo "</a>";
		 }
		
		 
		 if($total > 21){
		   for($i=1; $i <=20; $i++){
			   echo "<a href='".$suffix.$i."'><div id='page_number' style='width:20px;'>".$i."</div></a>";
			   
		   }
		   
			echo "<div id='page_number' style='border:0px;font-size:20px' >.....</div>";
			echo "<a href='".$suffix.$total."'><div id='page_number' style='width:20px;'>".$total."</div></a>";
	    }else{
			for($i=1; $i<= $total; $i++){
		
					 if($page !=$i){
							echo "<a href='".$suffix.$i."'>"; 
					 }
					
						
						echo "<div id='page_number' style='width:20px;'>".$i."</div>";
						if($page !=$il){
							echo "</a>";
						}
						
			   
					
		   
			}
			
		}
		if($page < $total){
			
			
	
		echo "<a href='".$suffix.($page+1)."'>";
			}
		echo "<div id='page_number'>&gt;&gt;</div>";
		
	if($page < $total){
		echo "</a>";
	}
		
		echo "</div>";
		
		
	}
	
}

?>

<?php
if(isset($_GET['recipe_id'])){
	$blog_id=$_GET['recipe_id'];
	$sql="SELECT * FROM comment WHERE blog_id='".$blog_id."'";
	$query=mysql_query($sql) or die(mysql_error());
	
	
	echo "<br/><br/><br/><br/><br/> <hr/><br/>";
	if(mysql_num_rows($query) > 0){
		
		echo "<font id='comment_count'>".mysql_num_rows($query)." Comment on \"".$current_blog."\"</font><br/><br/>";
		$sql="SELECT * FROM comment WHERE blog_id='".$blog_id."' AND parent_id=0";
		$query=mysql_query($sql) or die(mysql_error());	
		while($tf=mysql_fetch_array($query)){
				echo "<div id='comment' class='main' name='".$tf['post_id']."'>";
				echo "<table border=0 id='".$tf['post_id']."'><tr><td></td><td>";
				echo "<div id='user_info'><a href='".$tf['website_url']."' id='blog_link' class='comment_link'>".$tf['name']."</a><br/>
				".$tf['date_posted']." </div></td></tr></table>";
				echo $tf['post_text'];
			echo "<br/><br/><br/><table border=0><tr><td><div id='comment_button' ><a href='#response' parent_id='".$tf['post_id']."' id='blog_link' class='reply_link'>Reply</a></div></td> ";
			
			if(isset($_COOKIE['username'])){
				echo "<td><div id='comment_button'><a href='javascript:deleteComment(".$tf['post_id'].",".$tf['parent_id'].");' id='blog_link'  class='reply_link' style='display:inline'>Delete</a>  </div></td>";
			}	
			echo "</tr></table></div>";

				$sql="SELECT * FROM comment WHERE blog_id='".$blog_id."' AND parent_id='".$tf['post_id']."'";
			$nquery=mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($nquery) > 0){
				while($df=mysql_fetch_array($nquery)){
						echo "<div id='comment' class='reply' >";
	echo "  <table border=0 id='".$df['post_id']."'><tr><td>
	</td><td>
	<div id='user_info'><a href='".$df['website_url']."' id='blog_link' class='comment_link'>".$df['name']."</a><br/>
	".$df['date_posted']."</div></td></tr></table>
	";
	echo $df['post_text'];
	echo "<br/><br/><br/>";
	if(isset($_COOKIE['username'])){
		echo "<div id='comment_button'><a href='javascript:deleteComment(".$df['post_id'].",".$df['parent_id'].");' id='blog_link'  class='reply_link' style='display:inline'>Delete</a>  </div>";
	}
		echo "</div>";
	
				}
			}
			
		}
		
	}
	
	
	
	

	echo "<br/><br/><br/>";
	echo "<hr/>";
	echo "<div id='response'>";
	echo "<font id='label_title' class='reply_head'>Leave a Reply</font><br/><br/>";
	echo $error."<br/>";
	echo "<form action='index.php?recipe_id=".$blog_id."' method='post' >";
	echo "<font id='label_title' class='reply_label'>COMMENT</font><br/>";
	echo "<textarea id='comment_box' name='reply_comment' placeholder='type a comment'></textarea><br/><br/>";
	echo "<font id='label_title' class='reply_label'>NAME</font><br/>";
	echo "<input id='blog_input' class='reply_input' name='reply_name' placeholder='type your name'/><br/><br/>";
	echo "<font id='label_title' class='reply_label'>EMAIL</font><br/>";
	echo "<input id='blog_input' class='reply_input' name='reply_email' placeholder='Type EMAIL'/><br/><br/>";
	echo "<font id='label_title' class='reply_label'>WEBSITE</font><br/>";
	echo "<input id='blog_input' class='reply_input' name='reply_website' placeholder='http://sample.com'/><br/><br/>";
	echo "<input id='blog_input' type='hidden' class='reply_input' name='parent_id' />";
	echo "<button name='post_comment' id='blog_button' class='comment_button'>POST COMMENT</button><br/>";
	
	echo "</form></div>";
}





?>