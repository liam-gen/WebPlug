<a href="https://webplugin.tk"><img src="https://webplugin.tk/cdn/banner.png"></a>
# WebPlugin
## Create a website easily in php
### [www.webplugin.tk](https://webplugin.tk)

---

[![version](http://webplugin.tk/cdn/v/0.0.4.svg)](http://webplugin.tk/changelogs/v0.0.4) &emsp; [![language](http://webplugin.tk/cdn/badges/language-php.svg)](http://php.net) &emsp; [![open source](http://webplugin.tk/cdn/badges/open-source.svg)](http://webplugin.tk)  &emsp; [![try now](http://webplugin.tk/cdn/badges/try-now.svg)](http://webplugin.tk/getstarted)

# About

WebPlug is a plugin that allows you to code a simple website in the php language.

> - Simple
> - Configurable
> - Fast
> - Optimized

# Installation

**Php 7.4.21 or newer is required.**

Download the zip file [here](https://webplugin.tk/download) and extract the files. Put it at the root and include the file WebPlug.php (`include("WebPlug.php");`) in your website's file.


# Example usage

Create and set up the site

`website.php`
```php
<?php
include("webplug-v0.0.4/WebPlug.php");

$d = __DIR__.DIRECTORY_SEPARATOR;

$p = new WebPlug(array(
    "settings" => array(
        "name" => "WebPlug",
        "debug" => true,
        "scripts" => array("js/script.js"),
        "icon" => "assets/icon.png",
        "stylesheets" => array("css/style.css")
    ),
    "pages" => array(
        0 => array(
            "name" => "{site.name} | Home",
            "link" => "",
            "file" => $d."index.php",
            "scripts" => array("js/jquery.js")
        ),
        1 => array(
            "name" => "{site.name} | Page",
            "link" => "page",
            "file" => $d."page.php",
            "stylesheets" => array("css/fonts.css"),
        ),
    ),
));
?>
```

`index.php` (yourwebsite.com)
```php
<?php
include("website.php"); 
$p->load(0);
$p->write("{page.name}");
?>
<h1>Index</h1>
```

`page.php` (yourwebsite.com/page)
```php
<?php
include("website.php"); 
$p->load(1);
?>
<h1>Page</h1>
```

# Links
> - [Website](https://webplugin.tk)
> - [Documentation](https://webplugin.tk/en/docs)
> - [Download](https://webplugin.tk/download)
> - [Discord](https://webplugin.tk/discord)

# Collaborators

[![liamgen.js#1315](http://webplugin.tk/cdn/user/liamgenjs.png)](http://webplugin.tk/u/liamgenjs)

# License
This project is licensed under the MIT License - see the LICENSE.md file for details
