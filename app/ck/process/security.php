<? 
date_default_timezone_set('America/New_York');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);

ini_set('display_errors', 1);

session_start();
set_time_limit (600);

$no_log = true;
$no_log_page = $no_log_page ?? false;

require_once(ROOT_PATH . "/ck/db/handler.php");

$loged = false;
if ($_SESSION["ckloged"] && $_SESSION['ck_ip'] == md5($_SERVER['HTTP_USER_AGENT'])){
	
	$loged = true;
	$current_clerk = get_clerk($_SESSION["logclerk"],true);

    if (!$no_log_page) { rec_page_log();  }
	if(!$current_clerk->vars["available"]){
		session_destroy();		 
		header("Location: " . BASE_URL . "/index.php?1");
		exit();
	}else if(!$current_clerk->vars["new_pass"] && !$no_change_pass){
		header("Location: " . BASE_URL . "/ck/change_password.php");
		exit();
	}
}else{
    if (!$no_log_page) { rec_page_log('4'); }
	session_destroy(); 
	header("Location: " . BASE_URL . "/index.php?2");
	exit();
}

?>