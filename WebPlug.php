<?php

#
# WebPlug
# http://webplugin.tk
#
# (c) liamgen.js
#
# For the full license information, view the LICENSE.md file that was distributed with this source code.
#

class WebPlug
{
    public function __construct($params=array())
    {
        $this->params = $params;
        $this->infos = array("VERSION" => "0.0.4", "AUTHOR" => "liamgen.js#1315", "WEBSITE" => "www.webplugin.tk");
        if(empty($params["settings"]["debug"]) or $params["settings"]["debug"] != false)
        {
            $this->debug();
        }
        foreach ($params["pages"] as $p=>$v)
        {
            if(!$v["link"] == "") 
            {
                $this->makeHtacces($v);
            }
        }
    }

    /* PRIVATE & PROTECTED FUNCTIONS */

    protected function makeHtacces($params=array())
    {
        $htaccess = "RewriteRule ^".$params["link"]."$ ".$params["file"];
        if(!$this->isWrited(".htaccess", $htaccess)[0])
        {
            $file = fopen(".htaccess", "a+");
            fwrite($file, $htaccess."\n");
            fclose($file);
        }
    }

    private function isWrited($f, $l)
    {
        
        if ($file = fopen($f, "r")) {
            $line = 1;
            while(!feof($file)) {
                $text = fgets($file);
                if($text==$l."\n")
                    {
                        return array(true, $line);
                    }
                $line += 1;
            }
            fclose($file);
            return array(false, null);
        }
    }

    private function transform($str, $page)
    {
        $s = $this->params["settings"];
        $p = $this->params["pages"][$page];
        $tr = array("{site.name}" => $s["name"], "{page.name}" => $p["name"], "{page.id}" => $page, '{site.icon}' => $s["icon"], "{page.icon}" => $p["icon"]);
        foreach ($tr as $k=>$v)
        {
            $str = str_replace($k, $v, $str);
        }

        return $str;
    }

    /* PUBLIC FUNCTIONS */

    public function debug()
    {
        $files = array(".htaccess");
        foreach ($files as $f)
        {
            if (!file_exists($f)) {
                touch($f);
            }
        }
        
        if(!$this->isWrited(".htaccess", "rewriteengine on", true)[0])
            {
                $file = fopen(".htaccess", "w");
                fwrite($file, "RewriteEngine On"."\n");
                fclose($file);
            }
    }

    public function load($id)
    {
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

        if(isset($page["stylesheets"]) and !empty($page["stylesheets"]))
        {
            foreach($page["stylesheets"] as $sh)
            {
                echo "<link rel='stylesheet' type='text/css' href='".$sh."'>".$end;
            }
        }
        if(isset($s["stylesheets"]) and !empty($s["stylesheets"]))
        {
            foreach($s["stylesheets"] as $sh)
            {
                echo "<link rel='stylesheet' type='text/css' href='".$sh."'>".$end;
            }
        }

        ($page["seo"]) ? $this->generateSEO($page["seo"], $id) : "";

        echo "</head>".$end;
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
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.$e;
        }
    }
}
