<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$ticket = get_ticket($_POST["ticketid"]);
$dep = $_POST["department"];

$ticket->vars["dep_id_live_chat"] = $dep;

$ticket->update(array("dep_id_live_chat"));

header("Location: http://localhost:8080/ck/tickets.php");

?>