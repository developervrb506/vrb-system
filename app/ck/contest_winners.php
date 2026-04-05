<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("contest_winners_players")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Contests Winners</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Contests Winners</span>
<br />

<? /*$contests = get_all_checked_contests(); ?>
<? include "includes/print_error.php" ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Contest</td>
    <td class="table_header">Winners</td>
  </tr>
  <?
   $i=0; 
   foreach($contests as $cont){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $cont->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>">
		<a href="contest_winners_detail.php?contest=<? echo $cont->vars["id"]; ?>" class="normal_link">
        	View Winners (<? echo count(get_contest_players_results($cont->vars["id"], true)) ?>)
        </a>
    </td>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>

</div>
<?*/ include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>