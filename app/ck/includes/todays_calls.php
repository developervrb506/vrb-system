<span style="font-size:11px;">
    <strong>CPH: </strong>Calls per Hour, 
    <strong>W#: </strong>Wrong #, 
    <strong>RM: </strong>Remove Me, 
    <strong>DC: </strong>Disconnect,
    <strong>NUS: </strong>Non US, 
    <strong>LIM: </strong>Limbo,  
    <strong>NA: </strong>No Answer,     
    <strong>CB: </strong>Call Back, 
    <strong>LM: </strong>Left Message, 
    <strong>EM: </strong>Email Me, 
    <strong>SUI: </strong>Signup Incoming , 
    <strong>SUO: </strong>Signup Outgoing , 
    <strong>DEP: </strong>Deposit , 
    <strong>TC: </strong>Total Calls
</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">#</td>
    <td class="table_header">Clerk</td>
    <td class="table_header" align="center">CPH</td>
    <td class="table_header" align="center">W#</td>
    <td class="table_header" align="center">RM</td>
    <td class="table_header" align="center">DC</td>
    <td class="table_header" align="center">NUS</td>
    <td class="table_header" align="center">LIM</td>
    <td class="table_header" align="center">NA</td>
    <td class="table_header" align="center">CB</td>
    <td class="table_header" align="center">LM</td>
    <td class="table_header" align="center">EM</td>
    <td class="table_header" align="center">SUO</td>
    <td class="table_header" align="center">SUI</td>
    <td class="table_header" align="center">DEP</td>
    <td class="table_header" align="center">TC</td>
  </tr>

<?
if(!isset($day)){$day = date("Y-m-d");}

$clerks = get_all_clerks("","2,4");
foreach($clerks as $ck){$ck->calls_per_hour = $ck->calculate_calls_per_hour($day);}
usort($clerks, array("clerk", "sort_by_cph"));
$i=0;

foreach($clerks as $ck){
    if($i % 2){$style = "1";}else{$style = "2";}$i++;
    ?>
    <tr <? if($i == 1){echo 'style=" font-weight:bold;"';}?>>
        <td class="table_td<? echo $style ?>" align="center"><? echo $i; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $ck->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $ck->calls_per_hour; ?></td>
        <?
		$status = get_all_name_status();
		foreach($status as $st){
			if($st->vars["id"]!= 1)
			{?><td class="table_td<? echo $style ?>" align="center"><? echo $ck->count_calls_by_status($st->vars["id"],$day); ?></td><? }
		}
		?>
        <td class="table_td<? echo $style ?>" align="center"><? echo $ck->count_calls_by_status("",$day); ?></td>
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
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>