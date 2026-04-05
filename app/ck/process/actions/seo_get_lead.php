<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?

$lead = get_seo_lead($current_clerk->vars["id"]);

if(!is_null($lead)){
	$lead->vars["status"] = 'a';
	$lead->vars["clerk"] = $current_clerk->vars["id"];
	$lead->update(array("status","clerk"));
	
	$log = new _seo_log();
	$log->vars["website"] = $lead->vars["id"];
	$log->vars["clerk"] = $current_clerk->vars["id"];
	$log->vars["ldate"] = date("Y-m-d H:i:s");
	$log->vars["action"] = "sa";
	$log->insert();
	
	header("Location: http://localhost:8080/ck/seo_lead_detail.php?l=".$lead->vars["id"]);
}else{
	?>
    <script type="text/javascript">
	alert("No Leads available");
	location.href = 'http://localhost:8080/ck/seo_get_lead.php';
	</script>
    <?
}



?>
<? }else{echo "Access Denied";} ?>