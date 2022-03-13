<a href="https://webplugin.tk"><img src="https://webplugin.tk/cdn/banner.png"></a>
# Create a website easily in php
### [www.webplugin.tk](https://webplugin.tk?utm_src=github-readme)

[![version](https://webplugin.tk/cdn/v/0.0.7.svg)](https://webplugin.tk/changelogs/v0.0.7) &emsp; [![language](https://webplugin.tk/cdn/badges/language-php.svg)](https://php.net) &emsp; [![open source](https://webplugin.tk/cdn/badges/open-source.svg)](https://webplugin.tk)  &emsp; [![try now](https://webplugin.tk/cdn/badges/try-now.svg)](https://webplugin.tk/getstarted)

# About

WebPlug is a plugin that allows you to code a simple website in the php language.

- Simple
- Configurable
- Fast
- Optimized

# Installation

**Php 7.4.21 or newer is required.**

Download the zip file [here](https://webplugin.tk/download) and extract the files. Put it at the root and include the file WebPlug.php (`require_once("webplug-v0.0.7/src/WebPlug.php");`) in your website's file.

# Example usage

Create and set up the site

`yoursitefile.php`
```php
<?php
require_once("webplug-v0.0.7/src/WebPlug.php");

$d = __DIR__.DIRECTORY_SEPARATOR;

$p = new WebPlug(array(
    "settings" => array(
        "name" => "WebPlug",// required
        "debug" => true,
        "lang" => "en", // default: en (en, fr)
        "scripts" => array("js/script.js"),
        "icon" => "assets/icon.png",
        "styles" => array("css/style.css"),
        "admin" => array( // required
			"username" => "admin",
			"password" => "admin123"
		)
    ),
    "pages" => array(
        0 => array(
            "name" => "{site.name} | Home",// required
            "link" => "/",// required
            "file" => $d."index.php",// required
            "scripts" => array("js/jquery.js")
        ),
        1 => array(
            "name" => "{site.name} | Page",// required
            "link" => "page",// required
            "file" => $d."page.php",// required
            "styles" => array("css/fonts.css"),
        ),
    ),
    "errors" => array(
		"404" => array("file" => $d."errors/404.php")
	),
));
?>
```
> **Note**: For the first launch, go to https://website.com/yoursitefile.php to debug the site


`index.php` (website.com)
```php
<?php
require_once("yoursitefile.php"); 
PAGE->write("{page.name}");
?>
<h1>Index</h1>
```

`page.php` (website.com/page)
```php
<?php
require_once("yoursitefile.php"); 
?>
<h1>Page</h1>
```

> **Note**: To manage your site via the dashboard included on your site, go to https://website.com/admin/dash/board

# Links
> - [Website](https://webplugin.tk)
> - [Documentation](https://docs.webplugin.tk)
> - [Download](https://webplugin.tk/download)
> - [Discord](https://webplugin.tk/discord)

# Collaborators

[![liamgen.js#1315](http://webplugin.tk/cdn/user/liamgenjs.png)](http://webplugin.tk/u/liamgenjs)

# License
This project is licensed under the MIT License - see the LICENSE.md file for details
