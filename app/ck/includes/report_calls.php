
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
    <strong>SI: </strong>Signup , 
    <strong>SUI: </strong>Signup Incoming , 
    <strong>TC: </strong>Total Calls,
    <strong>DEP: </strong>Deposit , 
    <strong>RE: </strong>Release Me
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
    <td class="table_header" align="center">SI</td>
    <td class="table_header" align="center">SUI</td>
    <td class="table_header" align="center">DEP</td>
    <td class="table_header" align="center">RE</td>
    <td class="table_header" align="center">TC</td>
  </tr>

<?
if(!isset($from)){$from = date("Y-m-d");}
if(!isset($to)){$to = date("Y-m-d");}

$from_time = strtotime($from);
$to_time = strtotime($to);
$days = (($to_time - $from_time) / 60 / 60 / 24) + 1;

$clerks = get_all_clerks("","2");
foreach($clerks as $ck){
	$worked_days = 0;
	$ck->calls_per_hour = 0;	
	for($i=0;$i<$days;$i++){
		$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
		$cph_loop = $ck->calculate_calls_per_hour($day);
		if($cph_loop > 0){$ck->calls_per_hour += $cph_loop; $worked_days++;}
		
	}
	if($worked_days>0){$ck->calls_per_hour = round($ck->calls_per_hour / $worked_days,2);}else{$ck->calls_per_hour = 0;}
}
usort($clerks, array("clerk", "sort_by_cph"));
$x=0;
foreach($clerks as $ck){
    if($x % 2){$style = "1";}else{$style = "2";}$x++;
    ?>
    <tr <? if($x == 1){echo 'style=" font-weight:bold;"';}?>>
        <td class="table_td<? echo $style ?>" align="center"><? echo $x; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $ck->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $ck->calls_per_hour; ?></td>
        <?
		$status = get_all_name_status();
		foreach($status as $st){
			if($st->vars["id"]!= 1){
				$number = 0;
				for($i=0;$i<$days;$i++){
					$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));
					$number += $ck->count_calls_by_status($st->vars["id"],$day);
				}
				?><td class="table_td<? echo $style ?>" align="center"><? echo $number ?></td><?
            }
		}
		?>
        <?
		$total = 0;
		for($i=0;$i<$days;$i++){
			$day = date("Y-m-d",$from_time + ($i * 60 * 60 * 24));			
			$total += $ck->count_calls_by_status("",$day);
		}
		?>
        <td class="table_td<? echo $style ?>" align="center"><? echo $total; ?></td>
    </td>	
    <?
    
}
?>
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>

</table>