<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?


$action = param('ac');

switch($action){

   case 'c': // save prepaid card
        $card = param('d');

        $log = new ck_log();
		$log->vars["user"] = $current_clerk->vars["id"];
		$log->vars["ip"] = getenv(REMOTE_ADDR);;
		$log->vars["date"] = date("Y-m-d H:i:s");
		$log->vars["fail"] = 5; // no Fail code just manual inser
		$log->vars["data"] = 'PrepaidCard : '.$card	;
		$log->insert();

   break;
   default: break;

}

?>