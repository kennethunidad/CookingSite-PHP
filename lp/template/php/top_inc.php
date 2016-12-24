<style>
h2#title{
	font-family:"Forte";	
	padding-left:150px;
	font-size:40px;
	color:#405098;
	line-height:1em;
}
#description{
	margin-left:200px;
    font-weight:bold;
	
	font-size:25px;
	color:#black;
	font-family:"Papyrus";
}

#navigator{
	width:100%;
	height:40px;
	text-align:center;
	position:relative;
	float:left;
	background:rgba(0,175,175,0.7);
	
	text-align:center;
}
#table_link{
	margin-top:5px;
	width:90%;
	text-align:center;
}

#navigator ul,navigator ul li ul{
	
	list-style:none;
	
}
#navi{
   float:left;
	
	font-size:20px;

	text-align:left;
	height:30px;
	padding-top:10px;
	
}
#dropdown{
	display:none;
	z-index:1;
}



#navi:hover #dropdown{
    display:block;
	
	text-align:left;
	background:rgba(0,175,175,0.7);
	margin:0px;
    border-top:1px ridge #000055;
	
}
#navi:hover {
	background:rgba(100,175,175,0.7);
	
}
#navi-list li#dropdown:hover{
     background:rgba(100,175,175,0.7);
	
}
#navi-list{
	margin:0px;
	padding:0px;
	
}
.ddown{
	border-radius:0px 0px 10px 10px;
}
.main_list{
	width:1200px;
	background:rgba(0,175,175,0.7);
	
	
}
.admin_link{
	padding-left:20px;
	padding-right:20px;
	
}
</style>

<h2 id="title"> Lutong Pinoy</h2>
<div id="description"> Unang lasap talap na talap)</div><br/><div id="navigator">

<ul id='navi-list' class='main_list'>
<center>
<li id="navi">
<a href='index.php' id='links' class='admin_link'>Home</a>
</li>

<?php
   for($i=0; $i < count($cats); $i++){
   
	   echo "<li id='navi'><a href='index.php?category=".$cats[$i]."' id='links' class='admin_link'>".$cats[$i]."</a></li>";
 }
?>
 


<?php
if(isset($_COOKIE['username'])){
	echo "<li id='navi'>";
	echo "<a href='index.php#admin_tool' id='links' class='admin_link'>Admin Menu &#10507;</a>";
	echo "<ul id='navi-list'>";
	echo "<li id='dropdown'>";
	echo "<a href='index.php?add_recipe' id='links' class='admin_link no_visible'>Add Recipe</a>";
    echo "</li>";
	echo "<li id='dropdown' class='ddown'><a href='index.php?logout' id='links' class='admin_link no_visible'>Logout</a></li>";
	echo "</ul></li>";
}
?>

</center>
</ul>


<?php


?>


</div>
