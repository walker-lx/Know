<?php
	require 'config.php';
	
	$query = "INSERT INTO comment (titleid, comment, user, date) 
	VALUES ('{$_POST['titleid']}', '{$_POST['comment']}', '{$_POST['user']}', NOW())";
	
	mysql_query($query) or die('新增失败！'.mysql_error());
	
	echo mysql_affected_rows();
	
	mysql_close();
?>