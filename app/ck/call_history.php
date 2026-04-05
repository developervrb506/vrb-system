<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?

  if (isset($_GET["account_name"])){
    $ckname = get_ckname_by_account($_GET["account_name"]);
  }
  else {
    $ckname = get_ckname($_GET["nid"]);
  }

$calls = search_calls("", $ckname->vars["id"]);
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
  	<td class="table_header" align="center">Call Id</td>
    <td class="table_header" align="center">List</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Time</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Conv. Res</td>
  </tr>
  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $name = get_ckname($call->vars["name"]);
	  $clerk = get_clerk($call->vars["clerk"]);
	  
  ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["list"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $clerk->vars["name"]; ?><br />(<? echo $clerk->vars["ext"]; ?>)</td>
    <td class="table_td<? echo $style ?>" align="center">
		<? echo date("M jS, Y",strtotime($call->vars["call_start"])); ?><br />
        <? echo date("g:i a",strtotime($call->vars["call_start"])); ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->call_time(); ?></td>
    <td class="table_td<? echo $style ?>" align="center" style="font-size:12px;"><? echo $call->get_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center" style="font-size:12px;">
    	<? 
		if(!is_null($call->vars["conversation_status"])){
			echo $call->vars["conversation_status"]->vars["name"];
			echo "<br />";
			echo date("g:i:s a",strtotime($call->vars["conversation_status_time"]));
		}else{
			echo "N/A";	
		}
        ?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>