<?php
	require 'config.php';
	
	$_sql = mysql_query("SELECT COUNT(*) AS count FROM comment WHERE titleid='{$_POST['titleid']}'");
	$_result = mysql_fetch_array($_sql, MYSQL_ASSOC);
	
	$_pagesize = 2;
	$_count = ceil($_result['count'] / $_pagesize);
	$_page = 1;
	if (!isset($_POST['page'])) {
		$_page = 1;
	} else {
		$_page = $_POST['page'];
		if ($_page > $_count) {
			$_page = $_count;
		}
	}
	
	$_limit = ($_page - 1) * $_pagesize;
	
	
	$query = mysql_query("SELECT ({$_count}) AS count,titleid,comment,user,date FROM comment 
	WHERE titleid='{$_POST['titleid']}' ORDER BY date DESC LIMIT {$_limit},{$_pagesize}") or die('SQL 错误！');
	
	$json = '';
	
	while (!!$row = mysql_fetch_array($query, MYSQL_ASSOC)) {
		foreach ( $row as $key => $value ) {
			$row[$key] = urlencode(str_replace("\n","", $value));
		}
		$json .= urldecode(json_encode($row)).',';
	}
	
	echo '['.substr($json, 0, strlen($json) - 1).']';
	
	mysql_close();
?>