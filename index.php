<?php

$page = $_GET['page'] ?? 'login';
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page); // sanitize

//include("includes/header.php");

$pagePath = "pages/{$page}.php";
if (file_exists($pagePath)) {
    include($pagePath);
} else {
    echo "<p>Page not found.</p>";
}

include("includes/footer.php");

?>