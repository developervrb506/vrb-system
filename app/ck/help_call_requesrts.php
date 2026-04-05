<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("help_calls")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Help Calls</title>

</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Help Calls</span><br />

<? include "includes/print_error.php" ?>

<? 
if(isset($_GET["cid"])){
	$call = get_help_call(clean_str_ck($_GET["cid"]));
	$call->vars["status"] = "ca";
	$call->update(array("status"));
}


$calls = get_pending_help_calls();
?>

<? if (count($calls) > 0) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Player</td>
    <td class="table_header">Name</td>
    <td class="table_header">Phone</td>
    <td class="table_header">Request</td>
    <td class="table_header">Date</td>
    <td class="table_header"></td>
  </tr>
  <tr>
    <? echo "<strong>".$name_list."</strong><br>" ?>
  </tr>
  

<? foreach($calls as $call){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
    ?>
   <tr>
   	<td class="table_td<? echo $style ?>"><? echo $call->vars["player"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $call->vars["name"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $call->vars["phone"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $call->vars["request"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $call->vars["tdate"] ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<input type="button" value="Called" onclick="location.href = 'help_call_requesrts.php?cid=<? echo $call->vars["id"]; ?>'" />
    </td>
   </tr>
  <? }?> 
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>

<? } else { echo "No pending calls found"; }  ?>
</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>