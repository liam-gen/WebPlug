<?php
function page_load($params=array(), $th=false)
{
	require_once("includes/langs.php");
	define("_PAGE", constant("PAGE_04"));
	require_once("includes/head.php");
	require_once("includes/navbar.php");
	//require_once("../../WebPlugObject.php");
	_load("security");
	
	if(isset($_POST["clear_cache"]) && !empty($_POST["clear_cache"]))
	{
		$th->clearCache();
		$msg = array("status" => "success", "msg" => _PAGE["success_msg"]);
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
		<?php } ?><br><br>

		<form action="" method="POST">
			<button class="btn" type="submit" value="clear_cache" name="clear_cache"><?= _PAGE["clear"] ?></button>
		</form>

    </div>
  </section>
  <?php
		require_once("includes/script.php");
	?>

</body>
</html>

<?php } ?>