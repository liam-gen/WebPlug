<?php
	$langs = array("fr", "en");
	if(in_array($params["settings"]["lang"], $langs))
	{
		$dir = str_replace(basename(__DIR__), "", __DIR__);
		require_once($dir."langs/".$params["settings"]["lang"].".php");
	}
	else
	{
		$dir = str_replace(basename(__DIR__), "", __DIR__);
		require_once($dir."/langs/en.php");
	}
?>