<?php
include("website.php");

// Load the page with id
$p->load(2);

// Write the page id
$p->write("{page.id}");

// Create a button that sends data
$p->dataButton("index.php", array("text" => "hey"), array("test" => 1), true);
?>
<h1>Page2</h1>