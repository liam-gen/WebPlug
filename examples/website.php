<?php
include("WebPlug.php");

$d = __DIR__.DIRECTORY_SEPARATOR; // Get the website directory

$p = new WebPlug(array(
    "settings" => array(
        "name" => "WebPlug", // Website Name
        "debug" => true, // Debug initially
        "scripts" => array("https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"), // Scripts included in all pages
        "icon" => "icon.png", // Icon included on all pages Page (except if the page adds another icon)
        "stylesheets" => array("style.css") // Styles included in all pages
    ),
    "pages" => array(
        // 0, 1, 2 are the ids of the pages
        0  => array(
            "name" => "{site.name} | Home", // Page Title
            "link" => "", // Page link (let blank if it's the index)
            "file" => $d."index.php", // Page file
            "min" => true, // Minify the code
            "scripts" => array("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js") // Scripts in addition to those included in each page
        ),
        1 => array(
            "name" => "{site.name} | Page", // Page Title
            "link" => "page", // Page link (let blank if it's the index)
            "file" => $d."page.php", // Page file
            "min" => true, // Minify the code
            "stylesheets" => array("fonts.css"), // Styles in addition to those included in each page
            "seo" => array( // Page referencing
                "title" => "WebPlug - Page", // Page Title
                "description" => "Plugin to create a website simply in php", // Page description
                "keywords" => "webplug, web, plug, plugin, webplugin, WebPlug, Plugin Web, Web Plugin", // Page keywords
                "language" => "English", // Page language
                "author" => "liamgen.js", // Page author
                "embed" => array( // Embed
                    "type" => "website", // Embed type
                    "title" => "WebPlug", // Embed title
                    "description" => "Plugin to create a website simply in php", // Embed description
                    "url" => "www.webplugin.tk", // Embed url
                    "site_name" => "WebPlug", // Embed site name
                    "image" => "logo.png", // Embed image
                    ),
                "twitter" => array( // Twitter embed
                    "card" => "summary", // Twitter card
                    "title" => "WebPlug", // Twitter website title
                    "description" => "Plugin to create a website simply in php", // Twitter website description
                    "site" => "@webplug", // Twitter website website
                    "image" => "logo.png", // Twitter website image
                    "creator" => "liamgen.js" // Twitter website creator
                )
            )
        ),
        2 => array(
            "name" => "{site.name} | Page 2", // Page Title
            "link" => "page2", // Page url
            "file" => $d."page2.php" // Page file
        )
    ),
));
?>