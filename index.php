<?php
// $page = $_GET['page'] ?? 'home';
// include("includes/header.php");
// include("pages/{$page}.php");
// include("includes/footer.php");

// index.php
// $page = basename($_SERVER['REQUEST_URI']); // Get the last part of the URL path
// $page = trim($page, '/'); // Remove leading or trailing slashes
// $page = $page ?: 'home'; // Default to 'home' if no page is specified

// // Include the relevant pages
// include("includes/header.php");
// include("pages/{$page}.php");
// include("includes/footer.php");

$page = $_GET['page'] ?? 'home';
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page); // sanitize

include("includes/header.php");

$pagePath = "pages/{$page}.php";
if (file_exists($pagePath)) {
    include($pagePath);
} else {
    echo "<p>Page not found.</p>";
}

include("includes/footer.php");

?>