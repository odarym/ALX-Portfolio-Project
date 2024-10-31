<?php
	$pageTitle = "Index";

	include_once "includes/header.php";

	

	

	$url = $_GET['url'] ?? 'home';
	$url = explode('/', $url);

	$pageName = trim($url[0]);
	$fileName = $pageName.".php";

	if(file_exists($fileName))
	{
		require_once $fileName;
	}
	else
	{
		require_once "404.php";
	}

	// echo "<pre>";
	// print_r($url);



	include_once "includes/footer.php";
?>