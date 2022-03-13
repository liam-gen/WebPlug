<?php
require_once("webplug-v0.0.7/src/WebPlug.php");

$d = __DIR__.DIRECTORY_SEPARATOR;
$params = array(
    "settings" => array(
        "name" => "WebPlug",
		"lang" => "en",
        "scripts" => array("js/script.js"),
        "icon" => "assets/icon.png",
        "styles" => array("css/style.css"),
		"admin" => array(
			"username" => "admin",
			"password" => "admin123"
		)
    ),
    "pages" => array(
        0 => array(
            "name" => "{site.name} | Home",
            "link" => "/",
            "file" => $d."index.php",
            "scripts" => array("js/jquery.js")
        ),
        1 => array(
            "name" => "{site.name} | Page",
            "link" => "page",
            "file" => $d."page.php",
            "styles" => array("css/fonts.css"),
        ),
        2 => array(
            "name" => "{site.name} | Notifs",
            "link" => "notifs",
            "file" => $d."notifs.php",
        ),
    ),
	"errors" => array(
		"404" => array("file" => $d."404.php")
	),
);
$p = new WebPlug($params);
