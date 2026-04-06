<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("pph_ticker")){
?>
<?    
    if(isset($_GET["id"])){	
		$agent = get_hidden_agent_cashier(clean_get("id",true));
	
	    if(!is_null($agent)){
		  $agent->delete();
	    }
		
		header("Location: " . BASE_URL . "/ck/hidden_agents_cashier.php?e=101");
		
    }else{
        $agent = new _hidden_agents_cashier();
        $agent->vars["account"] = clean_get("account");
        $agent->insert();
		header("Location: " . BASE_URL . "/ck/hidden_agents_cashier.php?e=100");
    }

}
?>