<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?
$cat = get_ticket_categorie($_GET["c"]);
?>
<style type="text/css">
body {
	background-color: #FFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>
<span><strong>Instructions:</strong></span>
<div class="form_box">

<? echo nl2br($cat->vars["instructions"]); ?>
</div>
<BR>

<span><strong>Notes:</strong></span>
<div class="form_box">

<? echo $cat->vars["notes"]; ?>
</div>