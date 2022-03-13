<?php

function page_load($params=array())
{
	require_once("includes/langs.php");
	define("_PAGE", constant("PAGE_01"));
	require_once("includes/head.php");
	require_once("includes/navbar.php");
	_load("dashboard");
	$domain = $_SERVER['HTTP_HOST'];
	$url = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
	?>
  
  <section class="home-section">
	  
	  <?php
		require_once("includes/header.php");
	?>
    

    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic"><?= $domain ?></div>
            <div class="number"></div>
            <div class="indicator">
              <!--<i class='bx bx-link'></i>-->
				<span class="text"><a href="<?= $_SERVER["REQUEST_SCHEME"]."://".$domain ?>" target="_blank">GO</a></span>
            </div>
          </div>
          <!--<i class='bx bx-globe cart'></i>-->
        </div>
		  
		  <div class="box">
          <div class="left-side">
            <div class="box-topic">PHP</div>
            <div class="number"></div>
            <div class="indicator">
              <!--<i class='bx bx-link'></i>-->
				<span class="text"><?= PHP_VERSION ?></span>
            </div>
          </div>
          <!--<i class='bx bx-code cart'></i>-->
        </div>
		  
		  <div class="box">
          <div class="left-side">
            <div class="box-topic">WebPlugin</div>
            <div class="number"></div>
            <div class="indicator">
              <!--<i class='bx bx-link'></i>-->
				<span class="text">v<?= $params[".wp"]["VERSION"] ?></span>
            </div>
          </div>
          <!--<img class="cart" src="https://webplugin.tk/cdn/icon.png" width="20%">-->
        </div>
		  
		  <div class="box">
          <div class="left-side">
            <div class="box-topic">Github</div>
            <div class="number"></div>
            <div class="indicator">
              <!--<i class='bx bx-link'></i>-->
				<span class="text"><a href="https://webplugin.tk/github" target="_blank">GO</a></span>
            </div>
          </div>
          <!--<i class='bx bx-code-alt cart'></i>-->
        </div>
		  
		</div>
    </div>
  </section>

<script type="text/javascript">
  // don't forget all the other events you would like to stop
  toStop = ["click", "mousemove", "keypress"]
  for(var i = 0; i < toStop.length; i++) {
    iframe = document.getElementById("preview");
    iframe.addEventListener(toStop[i], function(event) {
      return false;
    }, false);
  }
</script>
<?php
		require_once("includes/script.php");
	?>

</body>
</html>

<?php } ?>