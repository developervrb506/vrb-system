<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
delete("rule_by_reads", "","rule = '". $_POST["rule"] ."' AND clerk = '". $current_clerk->vars["id"] ."'");
header("Location: ../../index.php");
?>