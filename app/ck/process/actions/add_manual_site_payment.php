<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("manual_sites_payments")){ ?>
<?

for($i;$i<=$_POST["total_players"];$i++){
	
	if(isset($_POST['payment_'.$i])){
		
	  $player_payment = new _manual_sites_payments();
	  $player_payment->vars['site'] = param('site');
	  $player_payment->vars['player'] = param('payment_'.$i);
      $player_payment->vars['date'] = param('date',false);	  
      $player_payment->vars['type'] = param('type');	  	  
	  $player_payment->insert();
	  
		 //INSERT DGS TRANSACTION
		$week = param('date',false);
		$player = param('payment_'.$i);
		
		$data = array();
		$data["pass"] = "sdft101404";
		$data["type"] = "R";
		$data["msg"] = "Week $week account load";
		$data["method"] = 2;
		$data["amount"] = 50000;
		$data["account"] = $player;
		
		$dgsID = do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/DGS_transaction.php",$data);
	  
	}
	
}
?>
<script type="text/javascript">parent.location.href = '../../manual_sites_payments.php?e=102';</script>
<? }else{echo "Access Denied";} ?>