<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("website_casino_access")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Casino Access by Website</title>
<?
if(isset($_GET["del"])){
	$del = new _account_transaction();
	$del->vars["transaction_id"] = $_GET["del"];
	$del->delete_all();
	?><script type="text/javascript">alert("Transaction has been Deleted");</script><?
}
?>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Casino Access by Website</span><br /><br />
  
<?
$casinos = get_all_casinos();
$webs = get_all_casino_websites();
$relations = get_all_casino_web_relations();
if(isset($_POST["Submit"])){
	//delete_all_casino_web_relation();
	foreach($webs as $web){
		foreach($casinos as $casino){ 
			if($_POST[$web["id"]."-".$casino["id"]]){
				if(!isset($relations[$web["id"]."-".$casino["id"]])){
					insert_casino_web_relation($casino["id"], $web["id"]);
				}
			}else{
				if(isset($relations[$web["id"]."-".$casino["id"]])){
					delete_casino_web_relation($casino["id"], $web["id"]);	
				}
			}
		}
	}
	$_GET["e"] = "95";
}
$relations = get_all_casino_web_relations();
?>
<? include "includes/print_error.php" ?> 


<p>Select the casinos you want to <strong>hide</strong></p>

<form method="post">

<input name="Submit" type="submit" value="Update" /><br /><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Website</td>
    <? foreach($casinos as $casino){ ?>
    	<td class="table_header" align="center" width="130"><? echo $casino["name"] ?></td>
    <? } ?>
  </tr>
  <?
  $i=0;
   foreach($webs as $web){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $web["url"] ?></td>
        <? foreach($casinos as $casino){ ?>
            <td class="table_td<? echo $style ?>" align="center" title="<? echo $casino["name"] ?>">
            	<input name="<? echo $web["id"] ?>-<? echo $casino["id"] ?>" type="checkbox" id="<? echo $web["id"] ?>-<? echo $casino["id"] ?>" title="<? echo $casino["name"] ?>" value="1" <? if(isset($relations[$web["id"]."-".$casino["id"]])){ ?> checked="checked" <? } ?> />
            </td>
        <? } ?>
      </tr>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

</table>

<br /><br />
<input name="Submit" type="submit" value="Update" />

</form>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>