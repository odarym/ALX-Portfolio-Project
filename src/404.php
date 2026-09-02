<?php
	$pageTitle = "Not Found";

	include_once "includes/header.php";
?>

<!-- FIX: Formatted 404 container with Bootstrap 5.3 theme-aware text-body-emphasis and text-body-secondary -->
<main class="container py-5 text-center">
	<div class="py-5">
		<h1 class="display-1 fw-bold text-body-emphasis">404</h1>
		<h2 class="h4 mb-3 text-body">Page Not Found</h2>
		<p class="lead text-body-secondary mb-4">The page you are looking for does not exist or has been moved.</p>
		<a href="<?=ROOT?>/home" class="btn btn-primary px-4 py-2 fw-semibold">Return to Home</a>
	</div>
</main>

<?php
	include_once "includes/footer.php";
?>