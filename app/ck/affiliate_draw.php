<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_draw")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliate Draw</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Affiliate Draw</span>
<div align="right"><span ><a href="./affiliate_draw_report.php" class="normal_link">Back to report</a></span></div>

<br /><br />
<div class="form_box" style="width:400px; padding:30px;">
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"account",type:"null", msg:"Please Insert the Account"});
validations.push({id:"amount",type:"numeric", msg:"Please Insert a Valid Amount"});
validations.push({id:"desc",type:"null", msg:"Please Insert a Description"});
<? if($_GET["sent"]){echo "alert('Draw has been inserted');";} ?>
<? if($_GET["aferror"]){echo "alert('Affiliate not found');";} ?>
</script>
<form method="post" action="process/actions/affiliate_draw_action.php" onsubmit="return validate(validations)">
Affiliate:<br />
<input name="account" type="text" id="account" />
<br /><br />
Amount:<br />
<input name="amount" type=amount"text" id="amount" />

<br /><br />
Description:<br />
<textarea name="desc" cols="35" rows="6" id="desc"></textarea>

<br /><br />

<input name="" type="submit" value="Send" />
</form>
</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>