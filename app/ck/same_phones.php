<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?
$phone = $_GET["phone"];
$current = $_GET["curr"];
$names = get_names_by_phone($phone,"",$current);
?>
<style type="text/css">
body {
	background-color: #FFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<?php /*?><td class="table_header" align="center"><strong>List</strong></td><?php */?>
    <td class="table_header" align="center"><strong>Account</strong></td>
    <td class="table_header" align="center"><strong>Clerk</strong></td>
    <td class="table_header" align="center"><strong>AF</strong></td>
    <td class="table_header" align="center"><strong>Call History</strong></td>
  </tr>
  
  <? foreach($names as $name){
	  if($i % 2){$style = "1";}else{$style = "2";} $i++;
	  
  ?>
  
  <tr>
    <?php /*?><td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["list"]->vars["name"]; ?></td><?php */?>
	<td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["acc_number"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $name->get_clerck_name(); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["aff_id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="call_history.php?nid=<? echo $name->vars["id"]; ?>" class="normal_link">
    		Call History
        </a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>