<?php

//change for config
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);

$srv="localhost";

$user_sql="id395987_lutongbahay";

$pass_sql="12345";

$db_name="id395987_lutongbahay";


mysql_connect($srv,$user_sql,$pass_sql) or die(mysql_error());


mysql_select_db($db_name) or die(mysql_error());


?>