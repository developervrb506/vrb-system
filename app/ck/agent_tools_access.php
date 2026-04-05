<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("sbo_agent_report")) {


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<title>Agent Tools Access</title>
</head>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Agent Tools Access</span><br /><br />
<? include "includes/print_error.php" ?>

<?

$i=0;
if (isset($_POST["from"])){
  $from = $_POST["from"];
  $to = $_POST["to"];
  $site = $_POST["site"];
}else{
 $from = "2015-10-01";
 $to = date("Y-m-d");
 $site = "";	
}
$data = get_all_agent_tools_access($from,$to,$site);
$no_data = get_all_agent_tools_no_access($from,$to,$site);

//$data = $data + $no_data;
if (!is_null($no_data)){
	$data = array_merge($data,$no_data);
}

$sites =  get_all_server_sites();
?>
<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Site:
    <select name="site">
     <option value="">All Sites</option>
     <? foreach($sites as $st) {?>
          <option <? if ($site == $st["id"]) { echo ' selected="selected" ';} ?> value="<? echo $st["id"] ?>"><? echo $st["site"] ?></option>
     <? }?>
    </select>
     <input type="submit" value="Search" />
</form>
<br />
   
    


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">ID</td>
    <td class="table_header" align="center">Report</td>
    <td class="table_header" align="center">URL</td>
    <td class="table_header" align="center">Total</td>
    
  </tr>
  <? foreach($data as $d){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $d["id"] ; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $d["tool"] ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $d["url"]?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $d["total"]?></td>
    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>

<? }else{echo "access Denied";} ?>
