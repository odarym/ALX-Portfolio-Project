<?php
	// Bootstrap core configuration, sessions, and functions
	include_once "core/init.php";

	// Parse route slug from URL parameter (defaults to 'home')
	$url = $_GET['url'] ?? 'home';
	$url = explode('/', $url);

	$pageName = trim($url[0]);
	$fileName = $pageName . ".php";

	// FIX: Removed duplicate header.php and footer.php inclusions from index.php.
	// Individual view files (home.php, blogs.php, login.php, etc.) manage their own
	// header/footer includes, and admin.php uses its own standalone dashboard layout.
	if (file_exists($fileName))
	{
		require_once $fileName;
	}
	else
	{
		require_once "404.php";
	}
?>