<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
//Array for table durango_name
$vars["firstname"] = clean_get("firstname");
$vars["lastname"] = clean_get("lastname");
$vars["address"] = clean_get("address");
$vars["city"] = clean_get("city");
$vars["state"] = clean_get("state");
$vars["zip"] = clean_get("zip");
$vars["available"] = 1;
 
	$durango_name = new durango($vars);
	$durango_name->insert("durango_name");

	
//Array for Table durango_control
$vars2["name"] = $durango_name->vars["id"];
$vars2["period"] = 0;
$vars2["priority"]=0;
$vars2["date"]= date("Y-m-d");

	$durango_control = new durango($vars2);
	$durango_control->insert("durango_control");

	
	
	header("Location: ../../index.php?e=73");

?>