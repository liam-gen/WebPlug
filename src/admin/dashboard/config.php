<?php 

function getRandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}


function rewrite($p=array(), $file)
{
	$file = str_replace("{rand_str}", getRandomString(8), $file);
	touch($file);
	$_fp = fopen($file, "w");
	fwrite($_fp, json_encode($p));
	fclose($_fp);
}

function page_load($params=array())
{
	require_once("includes/langs.php");
	define("_PAGE", constant("PAGE_03"));
	require_once("includes/head.php");
	require_once("includes/navbar.php");
	_load("config");
	

	if(isset($_POST))
	{
		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

			$secretAPIkey = '6LdP7p8eAAAAAA2g_et8q1g_-2v1rzCPHzjV7G0R';

			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

			$res = json_decode($verifyResponse);
			if($res->success)
			{
				if (isset($_POST["scripts"]) && is_array($_POST["scripts"])){
					$s = array();
					foreach($_POST["scripts"] as $script){
						$s[] = $script;
					 }
					rewrite($s, str_replace("admin/dashboard", "", __DIR__).".cache/scripts/{rand_str}");
					echo "<meta http-equiv='refresh' content='0'>";
				}
				
				if (isset($_POST["styles"]) && is_array($_POST["styles"])){
					$s = array();
					foreach($_POST["styles"] as $style){
						$s[] = $style;
					 }
					rewrite($s, str_replace("admin/dashboard", "", __DIR__).".cache/styles/{rand_str}");
					echo "<meta http-equiv='refresh' content='0'>";
					$msg = array("status" => "success", "msg" => _PAGE["success_msg"]);
				}
			}
		}
	}
	?>
  <section class="home-section">
	      	  <?php
		require_once("includes/header.php");
	?>
    <div class="home-content page">
		<?php
		if(isset($msg) & !empty($msg))
	{
		?>
		<div class="alert <?= $msg["status"] ?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <?= $msg["msg"] ?>
			</div>
		<?php } ?><br>
    	  <?php
		require_once("includes/header.php");
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://www.google.com/recaptcha/api.js?hl=<?= _PAGE["form-lang"] ?>" async defer></script>
<form method="post" action="" id="form">
	<fieldset>
				<legend><?= _PAGE["name"] ?></legend>
  <div class="wrapper-1">
	  <label for="name"><b>Scripts</b></label>
    <div class="input-box">
      <?php
		if(empty($params["settings"]["scripts"])) 
		{
			echo "<input type='text' name='scripts[]' value='$s'>";
		} 
		else
		{
			foreach($params["settings"]["scripts"] as $k=>$s)
			{
				if($k == 0)
				{
					echo "<input type='text' name='scripts[]' value='$s'>";
				}
			}
		}
	?>
      <button class="btn add-btn-1"><?= _PAGE["add-btn"] ?></button>
		<?php
		foreach($params["settings"]["scripts"] as $k=>$s)
			{
				if($k == 0)
				{
					continue;
				}
				else
				{
					$rbt = _PAGE['remove-btn'];
					echo "<div class='input-box'><input type='text' name='scripts[]' value='$s'> <a href='#' class='remove-lnk-1'>$rbt</a></div>";
				}
			}
	?>
    </div>
  </div>
		
		 <div class="wrapper-2">
	  <label for="name"><b>Styles</b></label>
    <div class="input-box">
      <?php
		if(empty($params["settings"]["styles"])) 
		{
			echo "<input type='text' name='styles[]' value='$s'>";
		} 
		else
		{
			foreach($params["settings"]["styles"] as $k=>$s)
			{
				if($k == 0)
				{
					echo "<input type='text' name='styles[]' value='$s'>";
				}
			}
		}
	?>
      <button class="btn add-btn-2"><?= _PAGE["add-btn"] ?></button>
		<?php
		foreach($params["settings"]["styles"] as $k=>$s)
			{
				if($k == 0)
				{
					continue;
				}
				else
				{
					$rbt = _PAGE['remove-btn'];
					echo "<div class='input-box'><input type='text' name='styles[]' value='$s'> <a href='#' class='remove-lnk-2'>$rbt</a></div>";
				}
			}
	?>
    </div>
  </div>
		
		<label for="send"><b><?= _PAGE["send-btn"] ?></b></label>
		<div class="g-recaptcha" data-sitekey="6LdP7p8eAAAAAEnxFTaB-BGEkPi9bndxz97jZTcV" data-callback="submitform"></div>
		</fieldset>
</form>
		<script>
			function submitform()
	{
		document.getElementById("form").submit();
	}
		</script>
<script type="text/javascript">
  $(document).ready(function () {
    var max_input = 10
    var x = 1;
    $('.add-btn-1').click(function (e) {
      e.preventDefault();
      if (x < max_input) {
        x++;
        $('.wrapper-1').append(`
          <div class="input-box">
            <input type="text" name="scripts[]"/>
            <a href="#" class="remove-lnk-1"><?= _PAGE["remove-btn"] ?></a>
          </div>
        `);
      }
    });
    $('.wrapper-1').on("click", ".remove-lnk-1", function (e) {
      e.preventDefault();
      $(this).parent('div').remove()
      x--;
    })
	  
	  $('.add-btn-2').click(function (e) {
      e.preventDefault();
      if (x < max_input) {
        x++;
        $('.wrapper-2').append(`
          <div class="input-box">
            <input type="text" name="styles[]"/>
            <a href="#" class="remove-lnk-2"><?= PAGE["remove-btn"] ?></a>
          </div>
        `);
      }
    });
    $('.wrapper-2').on("click", ".remove-lnk-2", function (e) {
      e.preventDefault();
      $(this).parent('div').remove()
      x--;
    })
 
  });
</script>
    </div>
  </section>

  <?php
		require_once("includes/script.php");
	?>

</body>
</html>

<?php } ?>