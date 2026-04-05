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
<? 
if (!isset($_POST["book_id"])) {  	
   $book = get_sportsbook($_GET["book"]); 
}
else {	
   $id = $_POST["id"];  
   $book = get_sportsbook($_POST["book_id"]);	   
}
?>
<div class="page_content" style="padding-left:50px;">
<span class="error"><? if (isset($_GET["e"])) { echo "<br /><br />" . get_error($_GET["e"]); }  ?></span>	
    <form method="post" action="../process/actions/endorsement_action.php">
    <div class="back_btn_div"><a href="tools.php" class="normal_link">&lt;&lt; BACK</a></div>
	<span class="page_title"><? echo ucwords($book->name) ?> Endorsement (<? echo ucwords($current_affiliate->web_name)?>)</span><br /><br />
	<p><span style="font-size:12px;">Add an endorsement below and it will show on the bottom of all your landing pages.<br />
Endorsements are a key component for conversions. We also supply a few default options for you to choose from below.</span><br /><br />
    <span class="small_black">Endorsement:</span><br />
    <input type="hidden" id="book_id" name="book_id" value="<? echo $book->id ?>"  />
    <? $endorsement = get_endorsement($current_affiliate->id, $book->id); ?>
    
    <? if (!isset($_POST["book_id"])) { ?>
    <textarea name="endo_<? echo $book->id ?>" cols="80" rows="5" id="endo_"><? echo $endorsement[0]; ?></textarea>
    <? } else { ?>
    <textarea name="endo_<? echo $book->id ?>" cols="80" rows="5" id="endo_"><? echo $_POST["endo".$id]; ?></textarea>
    <? } ?>  
      
    <br /><br />
    <span class="small_black">Signature:</span><br />
    <textarea name="signa_<? echo $book->id ?>" cols="30" rows="2" id="signa"><? echo $endorsement[1]; ?></textarea>&nbsp;&nbsp;<div style="margin-top:-60px; margin-left:270px;"><input type="image" src="../images/temp/submit.jpg" /></div>     
	</p>
	</form>
    <p><strong>Default Endorsements:</strong></p>
    <p>
     <? $endorsements = get_all_endorsements($book->id);
	 $i=0;
     foreach($endorsements as $endorsement){ 
	 $i=$i+1;
	 echo 'Endorsement # '.$i.'<br /><br />'; 
	 ?>      
     <form name="form<? echo $i ?>" id="form<? echo $i ?>" method="post" action="endorsement_new.php">
       <input type="hidden" id="book_id" name="book_id" value="<? echo $book->id ?>" />
       <input type="hidden" id="id" name="id" value="<? echo $i ?>" />       
       <textarea name="endo<? echo $i ?>" id="endo<? echo $i ?>" cols="80" rows="5"><? echo $endorsement->endorsement; ?></textarea>
       <input type="submit" name="Choose<? echo $i ?>" id="Choose<? echo $i ?>" value="Choose" />
     </form>	         
	 <? } ?>     
    </p>
</div>
<? include "../includes/footer.php" ?>