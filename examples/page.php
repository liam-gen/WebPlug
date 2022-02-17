<?php
include("website.php");

// Load the page with id
$p->load(1);

// Create an automatic redirect after two second to another page
$p->redirect("index.php", 2);
?>
<h1>Page</h1>