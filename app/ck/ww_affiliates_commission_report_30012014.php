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
$xml_lines = "";
$balance = 0;
$active_players = 0;
$new_players = 0;
$new_players_dep = 0;

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
		
		$xml_lines .= $agent->full_name()." \t ".$agent->vars["affiliatecode"]." \t ".$active_players." \t ".$new_players." \t ".$new_players_dep." \t $balance \t \n";		
		?>
  <tr title="<? echo $phone_name->vars["note"] ?>">
	<td class="table_td<? echo $style ?>"><? echo $agent->full_name(); ?></td>
    <td class="table_td<? echo $style ?>"><? echo $agent->vars["affiliatecode"]; ?></td>
	<td class="table_td<? echo $style ?>"><? echo $active_players; ?></td>
	<td class="table_td<? echo $style ?>"><? echo $new_players; ?></td>
	<td class="table_td<? echo $style ?>"><? echo $new_players_dep; ?></td>
	<td class="table_td<? echo $style ?>"><? echo $balance; ?></td>
  </tr>
    <? } ?>
<? 
$balance = 0;
$active_players = 0;
$new_players = 0;
$new_players_dep = 0;
}
?>
    <tr>
      <td class="table_last" colspan="5"></td>
    </tr>

</table>
<form method="post" action="affiliates_comission_report_export.php" id="xml_form">
<input name="lines" type="hidden" id="lines" value="<? echo $xml_lines ?>">
</form>