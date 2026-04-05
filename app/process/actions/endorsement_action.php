<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$aff = $current_affiliate->id;
$book  = $_POST["book_id"];
$endo = $_POST["endo_".$book];
$signa = $_POST["signa_".$book];

update_endorsement($aff,$book,$endo,$signa);

header("Location: ../../dashboard/endorsement_new.php?book=$book&e=5");

?>