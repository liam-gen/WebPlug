<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
	<title><?= TITLE ?></title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link rel='shortcut icon' href='https://webplugin.tk/cdn/icon.png'>
	  <link href='https://code.webplugin.tk/css/public/v0.0.7/dashboard.min.css' rel='stylesheet'>
	  <link href='https://code.webplugin.tk/css/public/v0.0.7/form.min.css' rel='stylesheet'>
   </head>
<body>
<?php
if(!$_SESSION["login"])
{
	echo "<meta http-equiv='refresh' content='0;url=login'/>";
	echo "<style>body{margin:20px}</style><div class='alert info'>Login redirection ...</div>";
	exit;
}
?>