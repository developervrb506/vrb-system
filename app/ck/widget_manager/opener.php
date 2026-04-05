<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
ini_set('memory_limit', '-1');
set_time_limit(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/js/jquery-ui.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script src="../includes/js/jquery-ui-1-11.js"></script>  
<script>
function progress_bar() {
	var val = 0;
	var interval = setInterval(function(){
		val = val + 1 ;
		 $('#pb').progressbar({value: val });
		 $('#percent').text(val + '%');
		 
		 if (val == 100){
			 clearInterval(interval);
		    $('#completed').text("Lines Updated");
		 }
		 
		},100);
	
	
	}

</script>
</head>
<body>


<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<?
 $opener = get_events_opener();
 //print_r($opener);
 $books = get_all_events_books(1,0); 
 $book = $opener->vars["opener"];
 $message = trim($_POST["message"]);
 

  if ($message != ""){
    
	$opener->vars["message"] =$message;
	$opener->update(array("message"));
	unset($_GET["book"]);
	
  } ?>
 <? if (isset($_GET["book"]) != ""){
    
	$opener->vars["opener"] = trim($_GET["book"]);
	$opener->update(array("opener"));
	
	
  } 
  
  $book = $opener->vars["opener"];
  ?>

<div class="page_content" style="padding-left:50px;">
<span class="page_title">Opener</span>&nbsp;&nbsp;&nbsp;<img style="margin-top:5px"  title="<? echo $opener->vars["opener"]?>" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/images/books/<? echo $opener->vars["opener"];?>_big.jpg" /><br /><br />

  <div align="right"><span ><a href="http://localhost:8080/ck/widget_manager/events_leagues.php">Back</a></span></div>

<div style="float:left; height:100px" >
<form action="" method="post" >
  
  <textarea name="message" rows="10" cols="50" ><? echo $opener->vars["message"] ?></textarea><BR>
  <input type="submit" value="Save Changes">
 
 </form>
 </div>
 <div style="float:left; margin-left:20px">
<form action="" method="get" >
  
  
  <span class=""><strong>Select a New Book as Opener</strong></span><BR>
 <select style="font-size:20px; height:35px" name ="book" onchange="this.form.submit()" >
   
  <option value ="">Select a Book</option>
  <? foreach ($books as $bk) {?>
     <option <? if ($book == ($bk->vars["small_name"]) ) { echo ' selected="selected" '; }?> value="<? echo trim($bk->vars["small_name"])?> "><? echo $bk->vars["book_name"]?></option>
  <? } ?>
  
  </select>
 </form>
  <?  if (isset($_GET["book"]) != ""){  ?>
 
    <BR>
    <div id="pb"></div>
    <div style="float:right;" id="percent"></div><BR>
    <div style="  margin-left: 30px; font-weight:bold" id="completed"> </div>
     <script>
	 progress_bar();
	 </script>
 
  <?
     $opener_obj = get_events_book("small_name","OP");
	 $new_opener = get_events_book("small_name",$_GET["book"]);
  
     $opener_obj->vars["feed_id"] = $new_opener->vars["feed_id"];
	 $opener_obj->update(array("feed_id"));
	 
	 $new_lines = get_history_lines_new_opener($new_opener->vars["id"]);
	 
	 //echo count($new_lines);
	 delete_old_opener_lines();
	 
	 foreach ($new_lines as $_line){
		 
		 
	                   $line = new _events_leagues_line();
					   $line->vars["book"]= $opener_obj->vars["id"];
					   $line->vars["league"]= $_line["league"];
					   $line->vars["line_date"]= $_line["line_date"];
			  	       $line->vars["away_rotation"]= $_line["away_rotation"];	
			  	       $line->vars["home_rotation"]= $_line["home_rotation"];	
			  	       $line->vars["away_money"]= $_line["away_money"];	
			  	       $line->vars["away_total"]= $_line["away_total"];	
			  	       $line->vars["home_money"]= $_line["home_money"];
			  	       $line->vars["home_total"]= $_line["home_total"];
					   $line->vars["period"]= $_line["period"];					   	
			  	       $line->vars["modification_date"]= date("Y-m-d H:i:s");						   					   					   				   					
					   $line->vars["away_spread"]= $_line["away_spread"];
			  	       $line->vars["home_spread"]= $_line["home_spread"];
					   $line->insert(); 	 
	 
	 
	 
	 }
	 
	 
  
  ?>
 
 
 <? } ?>
  </div> 
 
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
 


</div> 

<? include "../../includes/footer.php" ?>