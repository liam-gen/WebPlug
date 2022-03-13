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
	define("_PAGE", constant("PAGE_02"));
	require_once("includes/head.php");
	require_once("includes/navbar.php");
	_load("general");
	?>

<?php
	if(isset($_POST))
	{
		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

			$secretAPIkey = '6LdP7p8eAAAAAA2g_et8q1g_-2v1rzCPHzjV7G0R';

			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

			$res = json_decode($verifyResponse);
			if($res->success)
			{
				$p = array("name" => $_POST["name"]);
				$p["icon"] = $_POST["icon"];
				$p["lang"] = $_POST["lang"];
				rewrite($p, str_replace("admin/dashboard", "", __DIR__).".cache/settings/{rand_str}");
				echo "<meta http-equiv='refresh' content='0'>";
				$msg = array("status" => "success", "msg" => _PAGE["success_msg"]);
			}
			else
			{
				$msg = array("status" => "danger", "msg" => "Captcha error 21-x364");
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
		<form action="" method="POST" id="form">
			<fieldset>
				<legend><?= _PAGE["form-name"] ?></legend>
				
				<label for="name"><b><?= _PAGE["form-sitename"] ?></b></label>
				<input id="name" type="text" name="name" value="<?= $params["settings"]["name"] ?>">
				
				<label for="icon"><b>Icon</b></label>
				<input class="inp-icon" type="text" name="icon" value="<?= $params["settings"]["icon"] ?>">
				
				<br><br>
				
				<div class="form-select">
	
					<label for="language"><b><?= _PAGE["form-sitelang"] ?></b></label>

					<div class="form-select--container">

						<select id="lang-select" name="lang">
							<option value="en" <?= ($params["settings"]["lang"] == "en")?("selected"):("") ?>>English</option>
							<option value="fr" <?= ($params["settings"]["lang"] == "fr")?("selected"):("") ?>>Français</option>
						</select>

					</div>

				</div>
				
				<br><br>
				
				<div class="check">
					<p class="p-desc"><b><?= _PAGE["form-siteadvanced"] ?> :</b></p>
					<p class="m-10"><input type="checkbox" name="debug" id="debug" <?= ($params["settings"]["debug"]) ? ("checked") : ("") ?>>
						<label><?= _PAGE["form-sitedebug"] ?></label></p>
				</div>
				<br>
				<label><b><?= _PAGE["form-send"] ?></b></label>
					<div class="g-recaptcha" data-sitekey="6LdP7p8eAAAAAEnxFTaB-BGEkPi9bndxz97jZTcV" data-callback="submitform" hl="fr"></div>
				<!--<input type="submit" value="Sauvegarder">-->
			</fieldset>
		</form>
    </div>
  </section>

<script>
	function submitform()
	{
		document.getElementById("form").submit();
	}
</script>
  <?php
		require_once("includes/script.php");
	?>

<script src="https://www.google.com/recaptcha/api.js?hl=<?= _PAGE["form-lang"] ?>" async defer></script>
</body>
</html>

<?php } ?>