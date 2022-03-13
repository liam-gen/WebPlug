<?php
#
# WebNotifs
#
# Documentation link: https://docs.webplugin.tk/extras/modules/webnotifs
#
# (c) liamgen.js
#

require_once(dirname(__DIR__)."/WebModule.php");

class WebNotifs extends WebModule
{
	
	public function __construct($wp)
	{
    	parent::__construct($wp);
		$this->wp = $wp;
	}
	
	public function create()
	{
		$this->plugin = array("name" => "WebNotifs","version" => "0.0.1","author" => "liamgen.js");
	}
	
	public function pushNotification($params=array())
	{
		$bt = debug_backtrace();
        $caller = array_shift($bt);
		$id = $this->wp->getIdByFilePath($caller["file"]);
		$this->wp->params["pages"][$id]["scripts"][] = "https://code.webplugin.tk/js/public/v0.0.7/notifications.js";
		$this->temp["params-push-notif-01b"] = $params;
		$this->wp->on("load", function(){
			/* Create Notification */
			$params = $this->temp["params-push-notif-01b"];
			echo "<script>\nPush.create('".$params["title"]."', {";
			foreach($params as $k=>$v)
			{
				if($k == "title"){continue;}
				echo $k.": '".$v."',\n";
			}
			echo "onClick: function () {
		window.focus();\nthis.close();\n}\n})\n</script>";
			unset($this->temp["params-push-notif-01b"]);
		});
	}
}