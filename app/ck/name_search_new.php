<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/sales_security.php"); ?>
<?
if($current_clerk->vars["user_group"]->vars["id"] != 15 ){
	
if(isset($_POST["search"])){
	$phone = trim(clean_get("phone"));
	$email = trim(clean_get("email"));
	$player = trim(clean_get("player"));
	if($phone != "" || $email != "" || $player != ""){
		$names = _search_clerk_name($phone, $email, $player);
	}else{
		$names = array();	
	}
}else{
	$names = array();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Search Client</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Search Client</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box">
<form method="post">
<input name="search" type="hidden" id="search" value="1"  />
Phone: <input name="phone" type="text" id="phone" value="<? echo $phone ?>" />
&nbsp;&nbsp;&nbsp;
Email: <input name="email" type="text" id="email" value="<? echo $email ?>" />
&nbsp;&nbsp;&nbsp;
Account: <input name="player" type="text" id="player" value="<? echo $player ?>" />
&nbsp;&nbsp;&nbsp;
<input name="" type="submit" value="Search" />
</form>
</div><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Affiliate</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Last Name</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Phone</td>
    <td class="table_header" align="center">Enable</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Added</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
<?


?>
<? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>

  <tr>
  	<td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo "<strong>".$name->vars["aff_id"]."</strong>"; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["last_name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		echo $name->vars["phone"];
		if($name->vars["phone2"] != ""){
			echo "<br />".$name->vars["phone2"];
		}
		?>
    </td>
    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $name->print_status(); ?>
    </td>

    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? 
		if(is_null($name->vars["clerk"])){
			echo "Free";
		}else{
			echo "<strong>".$name->vars["clerk"]->vars["name"]."</strong>";
		}
		?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo $name->vars["status"]->vars["name"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
		<? echo date("Y-m-d",strtotime($name->vars["added_date"])); ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">Call History</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if($name->vars["on_the_phone"]){ ?>
        	<strong>BUSY</strong>
        <? }else{ ?>
        	<a href="call.php?vid=<? echo $name->vars["id"]; ?>" class="normal_link">Call</a>
        <? } ?>
    	
    </td>
  </tr>

<? } ?>
<tr>
  <td class="table_last" colspan="1000"></td>
</tr>
</table>
<? if(count($names)<1){echo "No Clients Found";} ?>
</div>
<? include "../includes/footer.php" ?>

<? } ?>