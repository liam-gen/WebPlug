<?php

/* Global settings */
define("TITLE", "WebPlug | Dashboard");
define("SEARCHBOX", "Search...");


/* Navbar */
define("NAV_01", "Dashboard");
define("NAV_02", "General");
define("NAV_03", "Setup");
define("NAV_04", "Security");
define("NAV_05", "Log out");

/* PAGES */
define("PAGE_01", array(
"name" => "Dashboard"
));
define("PAGE_02", array(
"name" => "General",
"form-name" => "General settings",
"form-sitename" => "Name",
"form-sitelang" => "Language",
"form-siteadvanced" => "Advanced",
"form-sitedebug" => "Debug",
"form-send" => "Checking & sending",
"form-lang" => "en",
"success_msg" => "<strong>Success!</strong> The information has been saved."
));
define("PAGE_03", array(
"name" => "Setup",
"add-btn" => "Add",
"send-btn" => "Save",
"remove-btn" => "Remove",
"form-lang" => "en",
"success_msg" => "<strong>Success!</strong> The information has been saved."
));
define("PAGE_04", array(
"name" => "Security & Privacy",
"clear" => "Clear cache",
"success_msg" => "<strong>Success!</strong> The cache has been successfully cleared."
));