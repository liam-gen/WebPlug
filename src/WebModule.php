<?php

#
# WebPlug
# https://webplugin.tk
#
# Documentation link: https://docs.webplugin.tk/extras/modules
#
# (c) liamgen.js
#
# For the full license information, view the LICENSE.md file that was distributed with this source code.
#

require_once('WebPlug.php');

use Files\FileManager;
use http\RequestManager;
use http\Router;


class WebModule
{
	protected $params;
	protected $Object;
	public function __construct($wp)
	{
		$bt = debug_backtrace();
        $caller = array_shift($bt);
		$this->Object = $wp;
		$this->Object->params["settings"]["debug"] = false;
		if(method_exists($this, "create"))
		{
			$this->create();
		}
	}
	
	protected function getParams()
	{
		return $this->wp->params;
	}
}