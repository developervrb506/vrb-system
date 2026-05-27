<?php

 // Conection compatible with PHP 8

$__config = __DIR__ . '/../../config.php';
if (file_exists($__config)) {
    require_once $__config;
}

class conn_db {
    public array $databases = [];
    //public ?object $sql_server_connector = null;
    var $sql_server_connector = NULL;
    public ?object $mysqli_connector = null;

    public function __construct() {

        $this->databases["clerk_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_clerks");
        $this->databases["mail_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_mails");
		$this->databases["sbolines_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_live_odds");
		$this->databases["processing_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_wu");
		$this->databases["betting_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_betting");
		$this->databases["tickets_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_tickets");
		$this->databases["accounting_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_accounting");
		$this->databases["livehelp_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_livehelp");
		$this->databases["baseball_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_baseball_file");
		$this->databases["mlb_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_mlb");
		$this->databases["nba_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_nba");
		$this->databases["nhl_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_nhl");
		$this->databases["nfl_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_nfl");
		$this->databases["props_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_props");
		$this->databases["tweets_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_tweet");
		$this->databases["sbo_sports_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_sports");
		$this->databases["sbo_seo_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_seo");
		$this->databases["sbo_liveodds_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_live_odds");
		$this->databases["sbo_posting"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_posting");
		$this->databases["inspinc_statsdb1"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_inspinc_statsdb1");
		$this->databases["inspinc_tweetdb1"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_inspinc_tweetdb1");
		$this->databases["affiliate_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_affiliates");
		$this->databases["sbo_book_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_book");
		$this->databases["sbo_breaket_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_marchmadness");
		$this->databases["tabs_db"] = new database(DB_HOST, DB_USER, DB_PASS, "vrbmarketing_tabs");

        // SQL
        //$this->databases["dgs_reports"] = new database("192.168.10.4", "sbo", "S0urs3C0nnect0r!", "DGSDATA", true); // new
    }

    public function connect($id) {

        global $__dgs_reports_replacement;

        if ($id == "dgs_reports" && $__dgs_reports_replacement != "") {
            $id = $__dgs_reports_replacement;
        }

        $db = $this->databases[$id];

        if ($db->sqlServer) {
            $this->sqlServerConnectionProcess($db->host, $db->user, $db->pass, $db->name);
        } else {
            $checkDb = $this->connectionProcess($db->host, $db->user, $db->pass, $db->name);
        }

        return $checkDb;
    }

    public function sqlServerConnectionProcess($dbhost, $dbuser, $dbpass, $dbname) {
        $connectionInfo = [
            "UID" => $dbuser,
            "PWD" => $dbpass,
            "Database" => $dbname,
            "ReturnDatesAsStrings" => true,
        ];
        $this->sql_server_connector = sqlsrv_connect($dbhost, $connectionInfo);

        // Después de la llamada a sqlsrv_connect()
if ($this->sql_server_connector === false) {
    $errors = sqlsrv_errors();
    if ($errors !== null) {
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
            echo "Code: " . $error['code'] . "<br />";
            echo "Message: " . $error['message'] . "<br />";
        }
    } else {
        echo "Error desconocido al intentar conectar a SQL Server.<br />";
    }
}

        if (!$this->sql_server_connector) {
             $errors = sqlsrv_errors();
    if ($errors !== null) {
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
            echo "Code: " . $error['code'] . "<br />";
            echo "Message: " . $error['message'] . "<br />";
        }
    }
            echo "Connection could not be established.<br />";
            die(print_r(sqlsrv_errors(), true));
        }
    }

    public function closeConnection() {
        if (!is_null($this->sql_server_connector)) {
            sqlsrv_close($this->sql_server_connector);
        }
    }

    public function connectionProcess($dbhost, $dbuser, $dbpass, $dbname) {
        global $mysqli;
        $check = true;

        $this->mysqli_connector = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        // Check connection
        if ($this->mysqli_connector->connect_error) {
            insert_error_log("MySQL", "Access denied for user $dbuser@$dbhost");
            $check = false;
            die("Connection failed: " . $this->mysqli_connector->connect_error);
        }

        if ($this->mysqli_connector->connect_error) {
            insert_error_log("MySQL", $this->mysqli_connector->connect_error);
            die("Connection failed: " . $this->mysqli_connector->connect_error);
            return $check;
            exit();
        } else {
           // echo "Connected successfully";
        }

        return $check;
    }
}

class database {
    public string $host, $user, $pass, $name;
    public bool $sqlServer;

    public function __construct($phost, $puser, $ppass, $pname, $psqlServer = false) {
        $this->host = $phost;
        $this->user = $puser;
        $this->pass = $ppass;
        $this->name = $pname;
        $this->sqlServer = $psqlServer;
    }
}

?>
