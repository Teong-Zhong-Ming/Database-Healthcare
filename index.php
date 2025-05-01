<?php
// $page = $_GET['page'] ?? 'home';
// include("includes/header.php");
// include("pages/{$page}.php");
// include("includes/footer.php");

// index.php
$page = basename($_SERVER['REQUEST_URI']); // Get the last part of the URL path
$page = trim($page, '/'); // Remove leading or trailing slashes
$page = $page ?: 'home'; // Default to 'home' if no page is specified

// Include the relevant pages
include("includes/header.php");
include("pages/{$page}.php");
include("includes/footer.php");

?>