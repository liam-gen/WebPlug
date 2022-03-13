<?php

class Tools
{
	public function __construct($page)
	{
		$this->page = $page;
	}
	
	public function is($item)
	{
		if($item == $this->page) {return "class='active'";} else {return "";}
	}
	
	public function url()
	{
		return array("domain" => $_SERVER['HTTP_HOST'], "full" => $_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"], "request" => $_SERVER["QUERY_STRING"], "security" => $_SERVER["REQUEST_SCHEME"]);
	}
	
	public function utmSrc()
	{
		return "utm_src=wp-logo-dash&domain=".$this->url()["domain"];
	}
}
function _load($page)
{
	$a = new Tools($page);
?>
<div class="sidebar">
    <div class="logo-details">
		<a href="https://webplugin.tk?<?= $a->utmSrc() ?>"><img src="https://webplugin.tk/cdn/logo.png" width="60" style="margin: 1px"></a>
      <span class="logo_name">WebPlug</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="board" <?= $a->is("dashboard") ?>>
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name"><?= NAV_01 ?></span>
          </a>
        </li>
        <li>
          <a href="general" <?= $a->is("general") ?>>
            <i class='bx bx-globe'></i>
            <span class="links_name"><?= NAV_02 ?></span>
          </a>
        </li>
		  <li>
          <a href="config" <?= $a->is("config") ?>>
            <i class='bx bx-cog'></i>
            <span class="links_name"><?= NAV_03 ?></span>
          </a>
        </li>
        <li>
          <a href="security" <?= $a->is("security") ?>>
            <i class='bx bx-lock-alt'></i>
            <span class="links_name"><?= NAV_04 ?></span>
          </a>
        </li>
        <li class="log_out">
          <a href="logout">
            <i class='bx bx-log-out'></i>
            <span class="links_name"><?= NAV_05 ?></span>
          </a>
        </li>
      </ul>
  </div>
<?php } ?>