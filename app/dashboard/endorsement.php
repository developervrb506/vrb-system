<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Endorsement</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $books = get_affiliate_sportsbooks($current_affiliate->id); ?>
<div class="page_content" style="padding-left:50px;">
<span class="error"><? if (isset($_GET["e"])) { echo "<br /><br />" . get_error($_GET["e"]); }  ?></span>
<?
foreach($books as $book){
?>
	<form method="post" action="../process/actions/endorsement_action.php">
	<span class="page_title"><? echo ucwords($book->name) ?> Endorsement (<? echo ucwords($current_affiliate->web_name)?>)</span><br /><br />
	<p><span style="font-size:12px;">Add an  endorsement below and it will show on the bottom of all your landing pages.<br />Endorsements are a key component for conversions.</span><br /><br />
      <span class="small_black">Endorsement:</span><br />
    <input type="hidden" id="book_id" name="book_id" value="<? echo $book->id ?>"  />
    <? $endorsement = get_endorsement($current_affiliate->id, $book->id); ?>
    <textarea name="endo_<? echo $book->id ?>" cols="80" rows="5" id="endo_"><? echo $endorsement[0]; ?></textarea>
    <br /><br />
    <span class="small_black">Signature:</span><br />
    <textarea name="signa_<? echo $book->id ?>" cols="30" rows="2" id="signa"><? echo $endorsement[1]; ?></textarea>
    <br /><br />
    <input type="image" src="../images/temp/submit.jpg" />
    <br /><br /><br />
	</p>
	</form>
<?
}
?>



</div>
<? include "../includes/footer.php" ?>