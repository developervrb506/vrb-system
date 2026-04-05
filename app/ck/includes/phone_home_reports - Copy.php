<? $report = new reporter(); ?>
<strong>Team:</strong> <span style="font-size:11px;">(Weekly)</span>
<? 
$report->set_date_to_this_week();
$items = $report->run("team_home");
$count = count($items[0]);
?>
<table width="30%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <? for($i=0;$i<$count;$i++){ ?>
    <td class="table_header"></td>
  <? } ?>
  </tr>
  <?   
  $i = 0;
  foreach($items as $item){
	  $i++;
	  if($i % 2){$style = "1";}else{$style = "2";}
  ?>
  <tr>
  	<td class="table_td<? echo $style ?>"><? echo $item["name"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $item["number"] ?></td>
  </tr>
  <? } ?>
  <tr>
  <? for($i=0;$i<$count;$i++){ ?>
    <td class="table_last"></td>
  <? } ?>
  </tr>
</table>

<br />

<strong>Fronters:</strong>
<? 
$report->restart();
$report->vars["from"] = date("Y-m-d");
$report->vars["to"] = date("Y-m-d");
$items = $report->run("fronters_home");
?>
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


<strong>Closers:</strong>
<? 
$report->restart();
$report->vars["from"] = date("Y-m-d");
$report->vars["to"] = date("Y-m-d");
$items = $report->run("closers_home");
?>
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