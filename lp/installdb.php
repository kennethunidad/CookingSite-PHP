<?php
/*this will create all tables needed for blog posting.*/

include "inc/db.config.php";

$sql_recipe_blog="CREATE TABLE recipe (id bigint primary key auto_increment, author_name varchar(65),date_published varchar(65),blog_id varchar(11),blog_title varchar(65) , blog_content longtext, blog_img varchar(250),category varchar(65))";
$sql_comment="CREATE TABLE comment (id bigint primary key auto_increment,name varchar(65) , post_id varchar(11), post_text longtext, email varchar(65),website_url varchar(65),date_posted varchar(65),blog_id varchar(11),parent_id varchar(11))";

//process sql query 

mysql_query($sql_recipe_blog) or die(mysql_error());
mysql_query($sql_comment) or die(mysql_error());




?>
