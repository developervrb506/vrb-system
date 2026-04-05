<? require_once(ROOT_PATH . "/ck/process/security.php"); ?>
<? $report = new reporter(); ?>
<? 
$report->restart();
$report->vars["from"] = date("Y-m-d");;
$report->vars["to"] = date("Y-m-d");;
$items = $report->run("agent_fronters_home");
?>


<strong>
    Agents Stats:
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
            <? if($item[count($item)-2] < 0){$extra = 'color:#C00; font-weight:bold;';}else{$extra = "";} ?>
            <td class="table_td<? echo $style ?>" style=" <? echo $extra ?>" align="center"><? echo $data?></td>
            <? }} ?>
          </tr>
  <? }
  } ?>
    <td class="table_last" colspan="100"></td>
</table>

<br />