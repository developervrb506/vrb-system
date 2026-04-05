<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("working_time_report") || $current_clerk->vars["id"] == $_GET["clk"]){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:20px; background:#fff;">
<?
$clerk = get_clerk($_GET["clk"]);
$date = $_GET["d"];
?>
<a href="javascript:;" class="normal_link" onclick="history.back(1)">&lt;&lt;Back</a><br />
<span class="page_title"><? echo $clerk->vars["name"] ?>'s Breaks on <? echo $date ?></span><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Time (H:m:s)</td>
    <td class="table_header" align="center">Start Time</td>
    <td class="table_header" align="center">Finish Time</td>
  </tr>

<?
$breaks = search_breaks($clerk->vars["id"] , $date, $date);
$i=0;
foreach($breaks as $break){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo sec2hms($break->get_time()); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo date("g:i a",strtotime($break->vars["start_time"])); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<? 
			if(!is_null($break->vars["end_time"])){echo date("g:i a",strtotime($break->vars["end_time"])); }
			else{echo "Currently in Break";}			
			?>
        </td>
    </td>	
    <?
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? }else{echo "Acces Denied";} ?>