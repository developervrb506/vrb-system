<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Moneypak Transactions</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Players Without Payouts</span>
<br /><br />

<? 
$players = get_nonpayouts_mp_players();
?>

<? include "includes/print_error.php" ?>

<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center"># Deps</td>
  </tr>
  <?
   $i=0; 
   foreach($players as $player){	   
       if($i % 2){$style = "1";}else{$style = "2";}
	   
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $player["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $player["total"]; ?></td>
  </tr>
  <? } ?>
   <tr>
    <td class="table_header" colspan="100"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>