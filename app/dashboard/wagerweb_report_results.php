<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<? require_once(ROOT_PATH . "/includes/wagerweb/classes.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?
$report = $_GET["report"];

switch ($report) {

case 1:      
   $params['report'] = 'commissions';        
   break;
	
case 2:
   $params['report'] = 'dailyfigures';   
   $period = $_GET["period"];   
   
   if ($period == 'thisWeek') {
	  $period = true;
   }
   else {
	  $period = false; 
   }
   
   $params['thisWeek'] = $period;  
   break;	
   
case 3:  
   $params['report'] = 'players';
   break;
   
case 4:
   $params['report'] = 'payouts';   
   $period = $_GET["period"];   
   $params['flag'] = $period;           
   break;
   
case 5:   
   $params['report'] = 'tracking';   
   $params['from']   = strtotime($_GET["from"]);
   $params['to']     = strtotime($_GET["to"]);
   break;
   
case 6:
   $params['report'] = 'transactions';   
   $params['from']   = strtotime($_GET["period"]);            
   break;                

case 7: 
   $params['report'] = 'openwagers';   
   $params['customerID'] = $_GET["customerid"];            
   break;                

case 8: 
   $params['report'] = 'wagerdetailsbydate';   
   $params['customerID'] = $_GET["customerID"];            
   $params['date']   = strtotime($_GET["date"]);
   break;
                   
case 9: 
   $params['report'] = 'wagerdetails';   
   $params['customerID']   = $_GET["customerID"];
   $params['ticketNumber'] = $_GET["ticketNumber"];
   $params['gradeNumber']  = $_GET["gradeNumber"];            
   break;         
}
?>
<?
$manager = new FactoryManagerImpl();
$results = $manager->send_action_to_manager('JasperManager',$params);

if (contains($results,'no_report_info_container')) {
   echo "<h3 align='center'>There is no information available</h3>";		
}
else {   
   $results = str_replace("/affiliates/account/report-open-wagers?","/dashboard/wagerweb_report_results.php?report=7&",$results);   
   $results = str_replace("/affiliates/account/report-aff-wager-details-by-date?","/dashboard/wagerweb_report_results.php?report=8&",$results);
   $results = str_replace("/affiliates/account/report-aff-wager-details?","/dashboard/wagerweb_report_results.php?report=9&",$results);  
   $results = str_replace("background-color: #000000","background-color: #fd7b03",$results);   
	   
   echo $results;	
}
?>
<script type="text/javascript">
parent.window.scrollTo(0,0);
</script>