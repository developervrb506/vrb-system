<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("contest_winners_players")){ ?>
<?
$contest = get_contest(clean_str_ck($_GET["contest"]));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $contest->vars["name"] ?> Winners</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title"><? echo $contest->vars["name"] ?> Winners</span>
<br />

<? $resutls = get_contest_players_results($contest->vars["id"]); ?>
<? include "includes/print_error.php" ?>
<? if(count($resutls)>0){ ?>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Player</td>
    <td class="table_header">Total Points</td>
  </tr>
  <?
   $i=0; 
   foreach($resutls as $resutl){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $resutl["player"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $resutl["total"]; ?></td>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>
<? }else{echo "Nobody played this contest.";} ?>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>