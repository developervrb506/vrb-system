<?

if (isset($_GET["date"])) { $date = $_GET["date"]; } else { $date = date("Y_m_d"); }

  $callback = isset($_GET['callback']);
    header('Content-Type: application/javascript');
    if ($callback) {
        echo "{$_GET['callback']}(";
    }
    echo file_get_contents("http://localhost:8080/ck/baseball_file/app/json_files/".$date."_schedules.json");
    if ($callback) {
        echo ")";
    }
    exit();
	
?>