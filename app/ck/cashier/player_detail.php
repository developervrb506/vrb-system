<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_admin")){ ?>
<? 
$account = clean_str_ck($_GET["pid"]);
$player = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?full=1&pid=".two_way_enc($account)));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>Player Information (<? echo $account ?>)</strong><br /><br />

<table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td class="table_td2">Win/Loss:</td>
    <td class="table_td2"><? echo (($player->vars->LifeTimeWin + $player->vars->LifeTimeLose) + $player->vars->LifeTimeNetCasino + $player->vars->LifeTimeNetHorses) ?> </td>
  </tr>
  <tr>
    <td class="table_td1">Current Balance:</td>
    <td class="table_td1"><? echo $player->vars->CurrentBalance ?> </td>
  </tr>
  <tr>
    <td class="table_td2">Available Balance:</td>
    <td class="table_td2"><? echo $player->vars->AvailBalance ?> </td>
  </tr>
  <tr>
    <td class="table_td1">Name:</td>
    <td class="table_td1"><? echo $player->vars->Name ?> <? echo $player->vars->LastName ?> </td>
  </tr>
   <tr>
    <td class="table_td2">Phone:</td>
    <td class="table_td2"><? echo $player->vars->Phone ?> </td>
  </tr>
   <tr>
    <td class="table_td1">Email:</td>
    <td class="table_td1"><? echo $player->vars->Email ?> </td>
  </tr>
   <tr>
    <td class="table_td2">Address:</td>
    <td class="table_td2">
		<? echo $player->vars->Country ?>, <? echo $player->vars->State ?>, <? echo $player->vars->City ?><br />
        <? echo $player->vars->Address1 ?>
    </td>
  </tr>
</table>



<? }else{echo "Access Denied";} ?>