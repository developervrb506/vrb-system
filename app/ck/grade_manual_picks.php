<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST)){
	$picks = get_all_ungraded_manual_picks();
	foreach($picks as $gpk){
		if($_POST["result_".$gpk->vars["id"]] != "" && is_numeric($_POST["juice_".$gpk->vars["id"]])){
			$gpk->vars["juice"] = $_POST["juice_".$gpk->vars["id"]];
			$gpk->vars["win"] = $_POST["result_".$gpk->vars["id"]];
			$gpk->update(array("win","juice"));
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Grade Picks</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<span class="page_title">Grade Picks</span><br /><br />
<? include "includes/print_error.php" ?>
<form method="post" action="?e=65">    
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Pick</td>
    <td class="table_header" align="center">Juice</td>
    <td class="table_header" align="center">Result</td>
  </tr>
  <?
  $i=0;
   $picks = get_all_ungraded_manual_picks();
   foreach($picks as $pk){
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($pk->vars["4and5star_comment"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<input name="juice_<? echo $pk->vars["id"]; ?>" type="text" id="juice_<? echo $pk->vars["id"]; ?>" size="5" />
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<select name="result_<? echo $pk->vars["id"]; ?>" id="result_<? echo $pk->vars["id"]; ?>">
    	  <option value="">--Select--</option>
    	  <option value="Y">Win</option>
    	  <option value="N">Loss</option>
    	  <option value="P">Push</option>
    	</select>
    </td>
  </td>
  <? } ?>
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"><input name="" type="submit" value="Grade" /></td>
  </tr>

</table>
</form>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>