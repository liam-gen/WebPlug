<?php
#
# WebPlug
# https://webplugin.tk
#
# (c) liamgen.js
#
# For the full license information, view the LICENSE.md file that was distributed with this source code.
#

namespace Files;
class FileManager
{
  public static function rootDirectory()
  {
    return $_SERVER['DOCUMENT_ROOT'];
  }

  public static function mkfile($filename)
  {
      touch($filename);
  }

  public static function fwrite($filename, $content, $method="w")
  {
    $file = fopen($filename, $method);
    fwrite($file, $content);
    fclose($file);
  }

  public static function search($filename, $q)
  {
      if ($file = fopen($filename, "r")) {
            $line = 1;
            while(!feof($file)) {
                $text = fgets($file);
                if($text==$q)
                    {
                        return array(true, $line);
                    }
                $line += 1;
            }
            fclose($file);
            return array(false, null);
        }
  }
	
  public static function fread($filename)
  {
    $file = fopen($filename, "r");
    $content = fread($file, filesize($filename));
    fclose($file);
	return $content;
  }
	
	public static function fstats($filename)
  {
	$arr = array();
		
    $file = fopen($filename, "r");
	$content = fread($file, filesize($filename));
    fclose($file);
		
	$arr["file"] = basename($filename);
	$arr["path"] = $filename;
	$arr["size"] = filesize($filename);
	$arr["content"] = $content;
	return $arr;
  }
}