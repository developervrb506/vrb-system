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
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliate <? echo ($_GET["aff"])?> Draw</span>
<br /><br />
<div class="form_box" style="width:290px; padding:30px;">
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript">
var validations2 = new Array();
validations2.push({id:"account",type:"null", msg:"Please Insert the Account"});
validations2.push({id:"amount",type:"numeric", msg:"Please Insert a Valid Amount"});
validations2.push({id:"desc",type:"null", msg:"Please Insert a Description"});
<? if($_GET["sent"]){echo "alert('Draw has been inserted');";} ?>
<? if($_GET["aferror"]){echo "alert('Affiliate not found');";} ?>
</script>
<form method="post" action="process/actions/affiliate_draw_action.php" onsubmit="return 
validate(validations2)">
<input name="swd_affiliate" type="hidden" id="swd_affiliate" />
<input name="account" type="hidden" id="account" value="<? echo ($_GET["aff"])?>" />
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

<? }else{echo "Access Denied";} ?>