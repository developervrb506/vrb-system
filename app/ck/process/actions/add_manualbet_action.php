<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?

$bet = new _bet();

$account = get_betting_account_by_name(clean_get("account"));
$idf = get_betting_identifier_by_name(clean_get("identifier"));

$bet->vars["account"] = $account->vars["id"];
$bet->vars["risk"] = clean_get("amount");
$bet->vars["win"] = clean_get("amount");
$bet->vars["identifier"] = $idf->vars["id"];
$bet->vars["type"] = "adjustment";

$bet->vars["bdate"] = clean_get("date");
$bet->vars["place_date"] = date("Y-m-d H:i:s");
$bet->vars["user"] = $current_clerk->vars["id"];

$bet->vars["account_percentage"] = $account->vars["description"];

$bet->vars["status"] = clean_get("type");

$bet->vars["comment"] = clean_get("comment");

$bet->insert();

$commissions = get_account_commission_relations($bet->vars["account"]);
foreach($commissions as $com){				
	$amount = $bet->get_commission_amount($com->vars["percentage"]);
	$status = $bet->get_commission_status();
		
	$abet = new _bet();				
	$abet->vars["account"] = $com->vars["caccount"];
	$abet->vars["risk"] = $amount;
	$abet->vars["win"] = $amount;
	$abet->vars["identifier"] = $bet->vars["identifier"];
	$abet->vars["type"] = "adjustment";				
	$abet->vars["bdate"] = $bet->vars["bdate"];
	$abet->vars["place_date"] = date("Y-m-d H:i:s");
	$abet->vars["user"] = $current_clerk->vars["id"];				
	$abet->vars["account_percentage"] = $com->vars["caccount"]->vars["description"];		
	$abet->vars["status"] = $status;				
	$abet->vars["comment"] = "Adjustment Commission From Account " . $account->vars["name"]."<br />Adjustment Id: ".$bet->vars["id"];
	$abet->vars["parent"] = $bet->vars["id"];	
	$abet->insert();
}

?>
<script type="text/javascript">parent.location.href = '../../betting_manual.php?e=44';</script>
<? }else{echo "Access Denied";} ?>