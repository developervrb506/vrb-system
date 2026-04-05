<?
session_start();
if($_SESSION['parent_aff_id'] != ""){
	$_SESSION['aff_id'] = $_SESSION['parent_aff_id'];
	$_SESSION['parent_aff_id'] = "";
}
?>