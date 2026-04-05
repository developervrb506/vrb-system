<? require_once(ROOT_PATH . "/ck/process/security.php"); ?>
<? $report = new reporter(); ?>
<? 
$report->restart();

$today = date("Y-m-d");
if(isset($_GET["yesterday"])){
	$rday = date("Y-m-d",strtotime($today."- 1 day"));
}else{
	$rday = $today;
}
$report->vars["from"] = $rday;
$report->vars["to"] = $rday;
$items = $report->run("fronters_home");
?>
<strong>
    <? if(isset($_GET["yesterday"])){ ?>
    	Yesterday's Sales Stats:  &nbsp;&nbsp;&nbsp;&nbsp;<a href="?" class="normal_link">View Today</a>
    <? }else{ ?>
        Today's Sales Stats:  &nbsp;&nbsp;&nbsp;&nbsp;<a href="?yesterday" class="normal_link">View Yesterday</a>
    <? } ?>
</strong>
<br />
<span style="font-size:11px;"><? echo $report->vars["explain"] ?></span><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <? $e = 0; foreach($items[0] as $top){ $e++; if($e>1){  ?>
    <td class="table_header" align="center"><? echo $top ?></td>
  <? }} ?>
  </tr>
  <?   
  $i = 0;
  foreach($items as $item){
	  $i++;
	  if($i % 2){$style = "1";}else{$style = "2";}
	  if($i>1){
  ?>
          <tr>
          	<? $e = 0; foreach($item as $data){ $e++; if($e>1){ ?>
            <td class="table_td<? echo $style ?>" align="center"><? echo $data?></td>
            <? }} ?>
          </tr>
  <? }
  } ?>
  <? foreach($items[0] as $top){ ?>
    <td class="table_last"></td>
  <? } ?>
</table>

<br />