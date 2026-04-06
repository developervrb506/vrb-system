<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
</head>
<body>
<?
 $leagues = get_all_event_leagues();

 $league = trim($_POST["league"]); 
 $league_details = get_event_league_details($league);
 
  if (isset($_POST["total"])){
	
	$str="";
	for ($x=1;$x<=$_POST["total"]+2; $x++){
	
	   if (!isset($_POST["book_".$x])){ $str .= $x.","; }	
		
	}
	
	$str = substr($str,0,-1);
	
	$league_details->vars["books_hide"]= $str;
	$league_details->update(array("books_hide"));
    ?><script> alert("Data Saved");</script><? 	
	  
  }

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Books For League <? echo $league ?></span><br /><br />
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>
<form action="" method="post" >
 
 
 League : 
 <select name ="league" onchange="this.form.submit()" >
  <option value ="">Select a League</option>
  <? foreach ($leagues as $le) {?>
     <option <? if ($league == trim($le->vars["league"]) ) { echo ' selected="selected" '; }?> value="<? echo trim($le->vars["league"])?> "><? echo $le->vars["league"]?></option>
  <? } ?>
  
  </select>
 </form>
 
 <?
 if ($_POST["league"] != ""){
 

 
 $books_hide = explode(",",$league_details->vars["books_hide"]);
 $hide = array();
 
  if (!empty($books_hide)){
	foreach( $books_hide as $bh){
	  $hide[$bh] = $bh;	
		
	}  
	  
  }
 
 // print_r($hide);
  
  
 $books = get_all_events_books(1,1);
 $actual = get_event_books_history($league, false);
 $history = get_event_books_history($league,true);
 ?>
 <form method="post" >
 <input type="hidden" name="league" value="<? echo $league ?>" />
 <input type="hidden" name="total" value="<? echo count($books); ?>" />
 <BR><BR><BR>
 <input style="width:140px; height:35px" type="submit" value="Save Changes"><BR><BR><BR>
 <table id="" width="60%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">SHOW</td> 
			<td width="100"  class="table_header" align="center" >Book</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Book has lines for this League">Actual Lines</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" title="Show If this Book had lines in last events ">History Lines</td>
            <td  name ="game_info_" width="80"  align="center"class="table_header">Last History Date</td>
		 </tr>  
		
		  <? foreach ($books as $book) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <input  <? if($book->vars["id"] != $hide[$book->vars["id"]]) { echo ' checked="checked" ';} ?> style="width:80px; height:25px" type="checkbox" name="book_<? echo $book->vars["id"]?>" value="<? echo $book->vars["id"]?>" />
               </td>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;">
			  <img  title="<? echo $book->vars["book_name"]?>" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/images/books/<? echo $book->vars["small_name"]; ?>_big.jpg" />
              </td> 
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
               <? if (isset($actual[$book->vars["id"]])) {  ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
              
              </td> 
               <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
                <? if (isset($history[$book->vars["id"]])) {  ?>
			    <img width="20px" src="<?= BASE_URL ?>/images/yes.png" />
			  <?  } else {?>
                 <img width="20px" src="<?= BASE_URL ?>/images/none.png" />
              <? }?>
                </td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $history[$book->vars["id"]]["line_date"]?></td> 

  <? } ?>
		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>

 <? } ?>
</div>
<? include "../../includes/footer.php" ?>