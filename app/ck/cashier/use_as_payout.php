<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<p><strong>Use deposit as Payout</strong></p>
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>

<form method="post" onsubmit="return validate(validations)" action="poster.php" target="_parent">
    <input name="way" type="hidden" id="way" value="use_for_payout" />
    <? $masked = ($_GET["home"]); ?>
    <input name="mask" type="hidden" id="mask" value="<? echo $masked ?>" />
    <input name="burl" type="hidden" id="burl" value="" />
    <script type="text/javascript">
	document.getElementById("burl").value = parent.location.href;
	</script>
  <div class="form_box">
        <p><strong></strong></p>
        <p>Player: <input name="player" type="text" id="player" /></p>
        <p>Is for an Affiliate?: <input name="is_af" type="checkbox" id="is_af" value="1" /></p>
        <p><input name="Submit" type="submit" id="Submit" value="Submit" /></p>
  </div>
</form>

<? }else{echo "Access Denied";} ?>