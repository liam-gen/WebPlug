<?php
require_once("website.php");

$_p = new WebNotifs(PAGE);
$_p->pushNotification(array("title" => "WebPlugin", "body" => "Test", "icon" => "https://webplugin.tk/cdn/icon.png"));
