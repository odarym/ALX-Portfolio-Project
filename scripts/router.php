<?php
/**
 * scripts/router.php
 * Built-in PHP development server router for OdaKira Blog.
 * Usage: php -S localhost:8000 -t src scripts/router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// FIX: Updated document root path from odakira to src to reflect new folder structure
$publicDir = realpath(__DIR__ . '/../src');
$requestedFile = $publicDir . $uri;

// If it's a real file (static asset: CSS, JS, images, etc.), serve directly
if ($uri !== '/' && file_exists($requestedFile) && !is_dir($requestedFile)) {
    return false;
}

// Set up the routing parameter expected by index.php
$urlPath = trim($uri, '/');
if (!empty($urlPath)) {
    $_GET['url'] = $urlPath;
}

// Change working directory to src so relative includes work seamlessly
chdir($publicDir);
require_once $publicDir . '/index.php';

