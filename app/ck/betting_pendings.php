<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Pendings Bets</title>
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
<span class="page_title">Pendings Bets</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
if($_GET["datef"]==""){$from = date('Y-m-d');}else{$from = $_GET["datef"];} 
if($_GET["datet"]==""){$to = date('Y-m-d');}else{$to = $_GET["datet"];} 
?>

Account: <input name="account" type="text" id="account" value="<? echo $_GET["acc"] ?>" /> 
<input type="button" value="Search" onclick="location.href = 'betting_pendings.php?acc='+document.getElementById('account').value" />

<?
$acc = str_replace(" ","",$_GET["acc"]);
$acc_obj = get_betting_account_by_name($acc);
if(!is_null($acc_obj)){
	$bets = get_pending_bets($acc_obj->vars["id"]);
	if(count($bets)>0){
?>

    <br /><br />
    
    <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="table_header" align="center">Id</td>
          <td class="table_header" align="center">Team</td>
          <td class="table_header" align="center">Risk</td>
          <td class="table_header" align="center">Win</td>
          <td class="table_header" align="center">Identifier</td>
          <td class="table_header" align="center"></td>
        </tr>
        
        <?
        $i=0;
         foreach($bets as $bet){
             if($i % 2){$style = "1";}else{$style = "2";}
             $i++;
        ?>
        <tr>
            <td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["id"]; ?></td> 
            <td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["team"]." ".$bet->vars["line"]; ?></td> 
            <td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["risk"]; ?></td> 
            <td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["win"]; ?></td> 
            <td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["identifier"]->vars["name"]; ?></td>  
            <td class="table_td<? echo $style ?>" align="center">
            	<a href="edit_bet.php?bid=<? echo $bet->vars["id"]; ?>&turl=../../betting_pendings.php?acc=<? echo $acc ?>" class="normal_link"  rel="shadowbox;height=450;width=475">Edit</a>
            </td>        
        </tr>
        <? }?>
        <tr>
          <td class="table_last"></td>
          <td class="table_last"></td>
          <td class="table_last"></td>
          <td class="table_last"></td>
          <td class="table_last"></td>
          <td class="table_last"></td>
        </tr>
    </table>
    <? }else{echo "<br /><br />No pending Bets for $acc";} ?>
<? }else if($acc!=""){echo "Account doesn't exist";} ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>