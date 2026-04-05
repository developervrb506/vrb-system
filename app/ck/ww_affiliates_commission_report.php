<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? include(ROOT_PATH . "/process/functions.php"); ?>
<? include(ROOT_PATH . "/includes/wagerweb/classes.php"); ?>
<?
set_time_limit(300);
$from   = date("m/d/Y",strtotime($_GET["from"]));
$to     = date("m/d/Y",strtotime($_GET["to"]));
$saf    = $_GET["saf"];
$agents = get_all_affiliates_by_brand(1);
?>

<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Code</td>
    <td class="table_header">Lifetime Players<br />(active):</td>
    <td class="table_header">New Players:</td>
    <td class="table_header">New Players <br />with Deposits:</td>
    <td class="table_header">Commission<br />Balance:</td>
  </tr>

<?
$i=0;
$j=0;
$xml_lines = "";
$balance = 0;
$active_players = 0;
$new_players = 0;
$new_players_dep = 0;
$report = array();

foreach($agents as $agent){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;	
	if($saf == "" || $saf == $agent->vars["affiliatecode"]){							
	  
		try {				
		    $params['affiliateID'] = $agent->vars["affiliatecode"];
            //$params['password']  = $agent->vars["password"];
			$params['password']    = md5($agent->vars["affiliatecode"]);								    
            $manager = new FactoryManagerImpl();
            @$manager->send_session_to_manager('JasperManager',$params);
					
			$params['report'] = 'getaffiliatestatus';					
			$manager = new FactoryManagerImpl();			
			@$results = $manager->send_action_to_manager('JasperManager',$params);		              
			
			//Get Current Balance					
            $balance = '$'.$results->Balance;			
			//Get Number of Active Players					
            $active_players = $results->ActivePlayers;			
									
			$params['report'] = 'getaffiliateupdatebydate';					
			$params['from']   = strtotime($from);
            $params['to']     = strtotime($to);														
			
			$manager = new FactoryManagerImpl();			
			@$results = $manager->send_action_to_manager('JasperManager',$params);			
			
			//Get quantity of new players					
            $new_players = $results->NewPlayers;
			
			//Get quantity of new players with deposits					
            $new_players_dep = $results->NewPlayersWithDeposit;			
							                  										
		} catch (Exception $e) {
           //echo 'Caught exception: ',  $e->getMessage(), "\n";
        }					
	 ?>
     <?
     $report[$j]["Name"]    = $agent->full_name();
     $report[$j]["Agent"]   = $agent->vars["affiliatecode"];
     $report[$j]["Status"]  = $active_players;	  
     $report[$j]["new"]     = $new_players;
	 $report[$j]["new_dep"] = $new_players_dep;
  	 $report[$j]["balance"] = $balance;
	 $j++;
	 ?>
  
    <? } ?>
<? 
$balance = 0;
$active_players = 0;
$new_players = 0;
$new_players_dep = 0;
}
?>

<?
$report = multisort($report,'new','Agent','Name','Status','new_dep','balance'); 
$report = array_reverse($report);

foreach($report as $rep){
   if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>	
		<tr title="<? echo $phone_name->vars["note"] ?>">
			<td class="table_td<? echo $style ?>"><?  echo $rep["Name"] ?></td>
            <td class="table_td<? echo $style ?>"><?  echo $rep["Agent"] ?></td>
			<td class="table_td<? echo $style ?>"><?  echo $rep["Status"] ?></td>
			<td class="table_td<? echo $style ?>"><?  echo $rep["new"] ?></td>
			<td class="table_td<? echo $style ?>"><?  echo $rep["new_dep"] ?></td>
			<td class="table_td<? echo $style ?>">$<? echo $rep["balance"] ?></td>
		</tr>
        <? 
		$balance = $rep["balance"];
		$xml_lines .= $rep["Name"]." \t ".$rep["Agent"]." \t ".$rep["Status"]." \t ".$rep["new"]." \t ".$rep["new_dep"]." \t $balance \t \n"; ?>	
    <? } ?>	
    <tr>
      <td class="table_last" colspan="5"></td>
    </tr>

</table>
<form method="post" action="affiliates_comission_report_export.php" id="xml_form">
<input name="lines" type="hidden" id="lines" value="<? echo $xml_lines ?>">
</form>