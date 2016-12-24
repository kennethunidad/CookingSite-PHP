<html>

<head>
<title> Lutong Pinoy > Add Recipe </title>
</head>
<body>
<style>
.create_input{
width:80%;
}
#blog_input.textarea_blog{
width:80%;
height:400px;
}
#blog_button.create_button{
	font-size:25px;
	color:white;
	margin-top:20px;
	padding:5px;
	background:rgb(0,175,175);
}

</style>

<?php
//update form
if(isset($_GET['update_recipe'])){
	$updateSql="SELECT * FROM recipe WHERE blog_id='".$_GET['update_recipe']."'";
	$query=mysql_query($updateSql) or die(mysql_error());
	if(mysql_num_rows($query)== 1){
		$tf=mysql_fetch_array($query);
		$blog_title=$tf['blog_title'];
		$blog_text=$tf['blog_content'];
		$blog_cat=$tf['category'];
	}
}


?>
<hr>
<div id='blockquote' class='info'>
<i class="fa fa-info-circle"></i>
<?php
if($_GET['update_recipe']){
	echo "This page will let you edit your recipe";
}else{
	echo "This page will able you to add your new recipe and will be posted in the home page";
}	

?>
</div><br/><br/>
<?php 
if(isset($error)){
echo "<div id='blockquote' class='error'><i class='fa fa-times-circle'></i>".$error."</div>"; 
}
if(isset($_GET['update_recipe'])){
$url="index.php?update_recipe=".$_GET['update_recipe']."";
}else{
$url='index.php?add_recipe';
}
?>


<form action='<? echo $url; ?>' method='post' enctype='multipart/form-data'>
<font id='label_title' class='label_blog'>Recipe Name :</font><br/>
<input type='text' id='blog_input' class='create_input' name='blog_title' value='<?php echo $blog_title; ?>' /><br/>
<font id='label_title' class='label_blog'>Recipe Category:</font><br/>
<select id='blog_input' class='create_input' name='recipe_cat'>
<option value='none' id='blog_input'>Choose Category</option>
<?php

for($i=0; $i < count($cats); $i++){

echo "<option value=".$cats[$i]." id='blog_input'>".$cats[$i]."</option>";
}
?>
</select><br/>

<font id='label_title' class='label_blog'>Recipe Content:</font><br/>
<textarea name='blog_text' id='blog_input' class='textarea_blog' placeholder='you can use html tags'><?php echo $blog_text; ?></textarea><br/>
<font id='label_title' class='label_blog'>Recipe Image:</font><br/>
<input type='file' id='blog_input' class='create_input' name='recipe_img' /><br/>
<button type='reset' id='blog_button' class='create_button'>Reset</button> &nbsp;<?php 
if(isset($_GET['update_recipe'])){
echo "<button type='submit' name='update_recipe' id='blog_button' class='create_button'>Update Recipe</button>";
}else{


echo "<button type='submit' name='add_recipe' id='blog_button' class='create_button'>Add Recipe</button>";
}
?>
</form>

</body>



</html>