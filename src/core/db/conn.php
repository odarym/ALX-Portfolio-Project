<?php

	$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
	if($serverName === "localhost")
	{
		define('DBUSER',"root");
		define('DBPASS',"");
		define('DBNAME',"myblog_db");
		define('DBHOST',"localhost");
	}
	else
	{
		define('DBUSER',"root");
		define('DBPASS',"");
		define('DBNAME',"myblog_db");
		define('DBHOST',"localhost");
	}


