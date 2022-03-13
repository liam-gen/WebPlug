<?php
session_start();
function exist($item)
{
	if(isset($item) and !empty($item)){return true;}else{return false;}
}
function page_load($params=array())
{
	require_once("includes/langs.php");
	if(exist($_POST["username"]) and exist($_POST["password"]))
	{
		if($params["settings"]["admin"]["username"] == $_POST["username"] and $params["settings"]["admin"]["password"] == $_POST["password"])
		{
			$_SESSION["login"] = 1;
			echo "<meta http-equiv='refresh' content='0;url=board'/>";
		}
	}
}
?>
<!DOCTYPE html><html lang="en"><head><link rel='shortcut icon' href='https://webplugin.tk/cdn/icon.png'><meta charset="UTF-8"><title>WebPlug - Login</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"><link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'><link href='https://code.webplugin.tk/css/public/v0.0.7/login.min.css' rel='stylesheet'></head><body>
<div class="pen-title">
  <h1>Login</h1>
</div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    <form method="POST" action="">
      <div class="input-container">
        <input name="username" type="#{type}" id="#{label}" required="required"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="password" type="password" id="#{label}" required="required"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span style="color: #ed2559 !important">Go</span></button>
      </div>
      <div class="footer" style="color: #ed2553">Powered by <a href="https://webplugin.tk?utm_src=login-page"><img src="https://webplugin.tk/cdn/banner.png" width="40%" style="vertical-align:middle;"></a></div>
    </form>
  </div>
</div>
<a id="codepen" href="https://webplugin.tk?utm_src=login-page" target="_blank" title="Powered by WebPlugin"><img src="https://webplugin.tk/cdn/logo.png" width="100%"></a>
<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script><script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script id="rendered-js" >$('.toggle').on('click',function(){$('.container').stop().addClass('active');});$('.close').on('click', function () {$('.container').stop().removeClass('active');});</script></body></html> 