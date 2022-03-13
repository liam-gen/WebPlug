<?php

#
# WebPlug
# https://webplugin.tk
#
# Documentation link: https://docs.webplugin.tk/class/webplug
#
# (c) liamgen.js
#
# For the full license information, view the LICENSE.md file that was distributed with this source code.
#

/* Remove this to debug entiere file */
error_reporting(E_ERROR | E_PARSE);


use Files\FileManager;
use http\RequestManager;
use http\Router;

class WebPlug extends Peridot\EventEmitter
{
    public function __construct($params=array())
    {
		$bt = debug_backtrace();
        $caller = array_shift($bt);
        $this->root = FileManager::rootDirectory();
		$this->cache_folders = array("settings", "scripts", "styles");
		$this->clearCache();
		(isset($this->params["onready"]) && !empty($this->params["onready"])) ? $this->ready() : "";
		$this->folder = str_replace($this->root, "",  str_replace(basename($caller["file"]), "", $caller["file"]));
        $this->params = $params;
		$this->admin($this->params);
		$this->loadCache($this->params);
        $this->infos = array("VERSION" => "0.0.7", "AUTHOR" => "liamgen.js#1315", "WEBSITE" => "www.webplugin.tk");
		foreach($this->infos as $k=>$v)
		{
			$this->params[".wp"][$k] = $v;
		}
        if(empty($params["settings"]["debug"]) or $params["settings"]["debug"] != false)
        {
            $this->debug();
        }
        $this->makeHtaccess($caller);
		$this->route($this->params);
	}

    /* PRIVATE & PROTECTED FUNCTIONS */

    protected function makeHtaccess($params=array())
    {
        $line = "RewriteRule ^(.+)$ ".basename($params["file"])." [QSA,L]";
        if(!FileManager::search(".htaccess", $line."\n")[0])
        {
            FileManager::fwrite(".htaccess", $line."\n", "a+");
        }
    }

    protected function transform($str, $page)
    {
        $s = $this->params["settings"];
        $_p = $this->params["pages"][$page];
        $tr = array("{site.name}" => $s["name"], "{page.name}" => $_p["name"], "{page.id}" => $page, '{site.icon}' => $s["icon"], "{page.icon}" => $_p["icon"]);
        foreach ($tr as $k=>$v)
        {
            $str = str_replace($k, $v, $str);
        }

        return $str;
    }
	
	protected function route($params=array())
	{
		$uri = $this->root.$_SERVER["REQUEST_URI"];
		$page = 0;
		define("PAGE", $this);
		$baseURL = $this->baseURL(str_replace("?".$_SERVER["QUERY_STRING"], "", $_SERVER["REQUEST_URI"]));
		if(file_exists($uri) and !is_dir($uri))
		{
			require_once($uri);$page=1;
		}
		foreach($params["pages"] as $k=>$p_)
		{
			if(file_exists($uri) and $p["file"] == $uri)
			{
				$this->load($k);
				require_once($uri);
				$page = 1;
				continue;
			}
			else if(file_exists($uri) and !isset($p["file"])  and !is_dir($uri))
			{
				require_once($uri);$page=1;continue;
			}
			else if(file_exists($this->root.$this->folder."index.php") and empty($baseURL) and $p_["link"] == "/")
			{
				$this->load($k);$page = 1;continue;
			}
			else if($p_["link"] == $baseURL and file_exists($p_["file"]) and str_starts_with($k, "root") or $p_["link"]."/" == $baseURL and file_exists($p_["file"]) and str_starts_with($k, "root"))
			{
				$this->load($k);
				require_once($p_["file"]);
				if(function_exists("page_load"))
				{
					page_load($this->params, $this);
				}
				$page = 1;
				continue;
			}
			else if($p_["link"] == $baseURL and file_exists($p_["file"]) or $p_["link"]."/" == $baseURL and file_exists($p_["file"]))
			{
				require_once($p_["file"]);
				$this->load($k);
				$page = 1;
				continue;
			}
			else if($p_["link"] == $baseURL and !file_exists($p_["file"]) or $p_["link"]."/" == $baseURL and !file_exists($p_["file"]))
			{
				require_once("templates/file_not_found.php");
				$f = str_replace($this->root, "", $p_["file"]);
				if($f[0] == "/"){
					$f = substr_replace($f,'',0,1);
				}
				make($f);
				$page = 1;
			}
		}
		if($page == 0)
		{
			if(file_exists($params["errors"]["404"]["file"]))
			{
				require_once($params["errors"]["404"]["file"]);
			}
			else
			{
				if(isset($params["errors"]["404"]["file"]))
				{
					require_once("templates/file_not_found.php");
					$f = str_replace($this->root, "", $params["errors"]["404"]["file"]);
					if($f[0] == "/"){
						$f = substr_replace($f,'',0,1);
					}
					make($f);
				}
				else
				{
					require_once("templates/404.php");
				}
			}
		}
	}
	
	private function admin(&$params=array())
	{
		$number = 1000;
		$pages = array("webplug" => "/templates/webplug.php", "admin/dash/board" => "/admin/dashboard/index.php", "admin/dash/settings" => "/admin/dashboard/settings.php", "admin/dash/general" => "/admin/dashboard/general.php", "admin/dash/action" => "/admin/dashboard/action.php", "admin/dash/config" => "/admin/dashboard/config.php", "admin/dash/security" => "/admin/dashboard/security.php", "admin/dash/login" => "/admin/dashboard/login.php", "admin/dash/logout" => "/admin/dashboard/logout.php");
		
		foreach($pages as $k=>$v)
		{
			$params["pages"]["root:".$number] = array(
			"link" => $k,
			"file" => __DIR__.$v
			);
			$number += 1;
		}
		
		$params["settings"]["scripts"][] = "https://code.webplugin.tk/js/public/copyrights.js";
		
		(isset($params["settings"]["icon"]) and !empty($params["settings"]["icon"])) ? ($params[".cache"]["icon-path"] = $this->root.$this->folder.$params["settings"]["icon"]) : ("");
		
		$params[".cache"]["this-folder"] = $this->folder;
		$params[".cache"]["this-root"] = $this->root;
	}
	
	protected function baseURL($url)
	{
		if($this->folder == "/") {return substr($url, 1);}
		return str_replace($this->folder, "", $url);
	}
		
	protected function getCache($path=__DIR__."/.cache")
	{
		$dir = scandir($path);
		foreach($dir as $k=>$v)
		{
			if($v == "." or $v == ".."){continue;}
			if(is_dir($path."/".$v))
			{
				$this->getCache($path."/".$v);
			}
			else
			{
				$file = $path."/".$v;
				$this->temp["cache-files-1b"][] = array("file"=>$file,"time"=>filemtime($file));
			}
		}
	}
	
	protected function getParams()
	{
		return $this->params;
	}
	
	protected function lastModifiedFile($path)
	{
		$cls_rii =  new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator( $path ),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		$ary_files = array();
		foreach ( $cls_rii as $str_fullfilename => $cls_spl ) {

			if($cls_spl->isFile())
			{
				$ary_files[] = $str_fullfilename;
			}
		}
		$ary_files = array_combine(
			$ary_files,
			array_map( "filemtime", $ary_files )
		);
		arsort( $ary_files );
		$str_latest_file = key( $ary_files );
		return array($str_latest_file, $ary_files[key( $ary_files )]);
	}
	
	public function clearCache()
	{
		$this->getCache();
		$files = array();
		foreach($this->cache_folders as $f)
		{
			$this->getCache(__DIR__."/.cache/".$f);
			foreach($this->temp["cache-files-1b"] as $v)
			{
				$this->getCache(__DIR__."/.cache/".$f);
				if(str_contains($v["file"], $f)){
					if($v["file"]==$this->lastModifiedFile(__DIR__."/.cache/".$f)[0]) 
					{
						if (($key = array_search($v["file"], $files)) !== false) {
							unset($files[$key]);
						}
						continue; 
					}
					else if(empty($this->lastModifiedFile(__DIR__."/.cache/".$f)[0]))
					{
						continue;
					}
					else
					{
						array_push($files, $v["file"]);
						unlink($v["file"]);
					}
				}
			}
		}
	}
	
	protected function loadCache(&$params=array())
	{
		foreach($this->cache_folders as $f)
		{
			$file = $this->lastModifiedFile(__DIR__."/.cache/".$f)[0];
			(!empty($file)) ? ($arr = json_decode(FileManager::fread($file))) : "";
			foreach($arr as $k=>$v)
			{
				if($f == "settings"){
					$params["settings"][$k] = $v;
				}
				else
				{
					if($this->is_dir_empty(__DIR__."/.cache/".$f)) { continue; }
					if(!empty($params["settings"][$f]) and in_array($v, $params["settings"][$f])){ continue;} 
					$params["settings"][$f][] = $v;
				}
			}
		}
	}
	
	protected function ready()
	{
		$p = $this->params["onready"];
		($p["clear_cache"]) ? $this->clearCache() : "";
	}
	
	protected static function is_dir_empty($dir)
	{
		if (!is_readable($dir)) {
			return null;
		}
		$handle = opendir($dir);
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				return false;
			}
		}
		return true;
	}

    /* PUBLIC FUNCTIONS */

    public static function debug()
    {
        $files = array(".htaccess");
        foreach ($files as $f)
        {
            if (!file_exists($f)) {
                FileManager::mkfile($f);
            }
        }
        
        if(!FileManager::search(".htaccess", "rewriteengine on")[0])
            {
                FileManager::fwrite(".htaccess", "RewriteEngine On\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_URI} !-l\nRewriteCond %{REQUEST_FILENAME} !\.(ico|css|png|jpg|gif|js)$ [NC]"."\n");
            }
    }

    public function load($id)
    {
		if(str_starts_with($id, "root:")) {return;}
        $page = $this->params["pages"][$id];
        $s = $this->params["settings"];
        ($page["min"]) ? ($end = "") : ($end = "\n");
        echo "<head>".$end;
        if(isset($page["name"]) and !empty($page["name"]))
        {
            $n = $this->transform($page["name"], $id);
            echo "<title>$n</title>".$end;
        }

        if(isset($page["icon"]) and !empty($page["icon"]))
        {
            $i = $page["icon"];
            echo "<link rel='shortcut icon' href='".$i."'>".$end;
        }
        else if(isset($s["icon"]) and !empty($s["icon"]))
        {
            $i = $s["icon"];
            echo "<link rel='shortcut icon' href='".$i."'>".$end;
        }

        if(isset($page["scripts"]) and !empty($page["scripts"]))
        {
            foreach($page["scripts"] as $script)
            {
                echo "<script src='".$script."'></script>".$end;
            }
        }
        if(isset($s["scripts"]) and !empty($s["scripts"]))
        {
            foreach($s["scripts"] as $script)
            {
                echo "<script src='".$script."'></script>".$end;
            }
        }

        if(isset($page["styles"]) and !empty($page["styles"]))
        {
            foreach($page["stylesheets"] as $sh)
            {
                echo "<link rel='stylesheet' type='text/css' href='".$sh."'>".$end;
            }
        }
        if(isset($s["styles"]) and !empty($s["styles"]))
        {
            foreach($s["styles"] as $sh)
            {
                echo "<link rel='stylesheet' type='text/css' href='".$sh."'>".$end;
            }
        }

        ($page["seo"]) ? $this->generateSEO($page["seo"], $id) : "";

        echo "</head>".$end;
		
		$this->emit("load");
    }

    public function getIdByFilePath($path)
    {
        foreach ($this->params["pages"] as $p=>$v)
        {
            if($v["file"] == $path) { return $p; } 
        }
    }

    public function write(string $string)
    {
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $i = $this->transform($string, $this->getIdByFilePath($caller["file"]));
        echo $this->transform($i, $this->getIdByFilePath($caller["file"]));
    }

    public function get(string $string)
    {
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $i = $this->transform($string, $this->getIdByFilePath($caller["file"]));
        return $this->transform($i, $this->getIdByFilePath($caller["file"]));
    }

    public function redirect($url, $time=1, $utm=true)
    {
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $pageID = $this->getIdByFilePath($caller["file"]);
        ($utm) ? $utm = "?utm_src=page_redirect&utm_id=".$pageID : $utm = "";
        echo "<meta http-equiv='refresh' content='$time;url=$url$utm'>";
    }

    public function getUserIp(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function dataButton($href, $button = array("text" => "", "class" => "", "id" => "", "style" => ""), $data = array(), $info = true)
    {
        
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $pageID = $this->getIdByFilePath($caller["file"]);
        ($this->params["pages"][$pageID]["min"]) ? $e = "" : $e = "\n";
        echo "<form action='$href' method='POST'>".$e;
        $datanum = 0;
        foreach($data as $k=>$v)
        {
            echo "<input type='hidden' name='$k' value='$v'>".$e;
            $datanum += 1;
        }
        if($info)
        {
            $datanum += 4;
            $ip = $this->getUserIp();
            echo "<input type='hidden' name='DATA_NUM' value='$datanum'>".$e;
            echo "<input type='hidden' name='DATA_UTM' value='data_button'>".$e;
            echo "<input type='hidden' name='DATA_PAGE' value='$pageID'>".$e;
            echo "<input type='hidden' name='DATA_IP' value='$ip'>".$e;
        }
        if(gettype($button) == "string")
        {
            echo $button;
        }
        else
        {
            ($button["class"]) ? $c = " class='".$button["class"].'' : $c = "";
            ($button["id"]) ? $i = " id='".$button["id"].'' : $i = "";
            ($button["style"]) ? $s = " style='".$button["style"].'' : $s = "";
            echo "<button type='submit'$c$i$s>".$button["text"]."</button>";
        }
        echo "</form>";

    }

    public function generateSEO($args=array(), $id, $a = true)
    {

        $page = $this->params["pages"][$id];
        ($page["min"]) ? ($e = "") : ($e = "\n");

        foreach($args as $k=>$v)
        {
            if($k == "embed")
            {
                foreach($args["embed"] as $k1=>$v1)
                {
                    echo "<meta property='og:$k1' content='$v1'>".$e;
                }
            }
            else if($k == "twitter")
            {
                foreach($args["twitter"] as $k1=>$v1)
                {
                    echo "<meta property='twitter:$k1' content='$v1'>".$e;
                }
            }
            else
            {
                echo "<meta name='$k' content='$v'>".$e;
            }
        }

        /* Additional content */
        if($a)
        {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'.$e;
        }
    }

    public function post($url, array $post, array $options=array())
    {
        return RequestManager::post($url, $post, $options);
    }
}