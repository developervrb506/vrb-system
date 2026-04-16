<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("bitcoin_address")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<title>Bitcoins Address Report</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>

<div class="page_content" style="padding-left:20px;">
<span class="page_title">Bitcoins Address </span><br /><br />
<? include "includes/print_error.php" ?> 


<?
$player = $_POST["player"];
$search = $_POST["search"]
?>
 
<form method="post">
Account: <input name="player" type="text" id="player" value="<? echo $player ?>" />
<input name="search" type="hidden" id="search" value="1" />
<input type="submit" value="Search" />
</form>
<br /><br />

<? if (isset($_POST["search"])) { ?>

<? $address = get_player_bitcoins_address($player); ?>


<? if (count($address)>0) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Address</td>
    <td class="table_header" align="center">Date</td>
  </tr>
    <? foreach($address as $_address){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $_address["address"]?></td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $_address["tdate"]?></td> 
  </tr>  

  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
 
</table>

<? } else { echo "There are not any Address for this Player"; } ?>




<? } ?>

</div> 
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>