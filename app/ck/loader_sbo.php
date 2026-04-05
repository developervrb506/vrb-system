<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?
if (isset($_POST["loader"])){
	$type = $_POST["loader"]; 
}else { $type = $_GET["type"];}
 
$data = $_GET["data"];
 
 
switch ($type) {
   
   case "agent" :
     	echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/all_transactions_by_agent.php?agent=".$data);
     break;
	 
   case "player" :  
     	echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/all_transactions_by_player.php?player=".$data);
     break;
	 
	case "dgs_payouts":
	    echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/last_payout_report.php?player=".$data);
	  break;
	 
	 case "dgs_deposit":
	    echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/all_transactions_by_player.php?player=".$data);
	  break;
	
	 
    case "balance_in_out":
      echo	do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/balance_in_out.php",$_POST);
     break;
	 
    case "balance_adjustments":
       echo	do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/balance_adjustment.php",$_POST);
      break;
	  
	 case "bonus_player":
	   echo do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_manage_bonus_players_action.php",$_POST); 
	  break;
	  
	 case "moneypak_transactions":
	     echo do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/create_moneypack_payout.php",$_POST); 
	  break;
	  
	  
	  
}


?>