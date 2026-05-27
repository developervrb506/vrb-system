<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
</head>
<body>
<?
 
  $books = get_all_events_books(1,0);
  
  if (isset($_POST["total"])){
	
	
	
	for ($x=1;$x<=$_POST["total"]+1; $x++){
	
	   if (isset($books[$x])){
		   if (!isset($_POST["active_".$x])) { $active = 0; } else {$active = 1;} 
		   $books[$x]->vars["available"] = $active;
		   $books[$x]->vars["landing_page"] = $_POST["landing_".$x];
		   $books[$x]->vars["book_name"] = $_POST["name_".$x];
		   $books[$x]->update(array("available","landing_page","book_name"));
			
		   }
	}
	
    ?><script> alert("Data Saved");</script><? 	
	  
  }

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Books Details <? echo $league ?></span><br /><br />
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>

 

 

<?  
$books = get_all_events_books(1,0);  

 
 ?>
 <form method="post" >
 <input type="hidden" name="league" value="<? echo $league ?>" />
 <input type="hidden" name="total" value="<? echo count($books); ?>" />
 <BR>
 <table id="" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            
			<td width="100"  class="table_header" align="center" >Book</td>
			<td  name ="game_info_" width="80"  align="center"class="table_header" >Display Name</td>
			<td  name ="game_info_" width="120"  align="center"class="table_header" title="Landing Page must exist in the Server" >Landing Page</td>
            <td  name ="game_info_" width="80"  align="center"class="table_header">ACTIVE</td>
		 </tr>  
		
		  <? foreach ($books as $book) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
              
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
			  <img  title="<? echo $book->vars["book_name"]?>" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/images/books/<? echo $book->vars["small_name"]; ?>_big.jpg" />
              </td> 
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
               <input type="text" value="<? echo $book->vars["book_name"]?>" name="name_<? echo $book->vars["id"] ?>" />
              
              </td> 
               <td  align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
                <input style="width:200px" type="text" value="<? echo $book->vars["landing_page"]?>" name="landing_<? echo $book->vars["id"] ?>" />
                </td> 
                <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
                  <input  <? if($book->vars["available"]) { echo ' checked="checked" ';} ?> style="width:80px; height:25px" type="checkbox" name="active_<? echo $book->vars["id"]?>" value="<? echo $book->vars["id"]?>" />
				  </td> 

  <? } ?>
              		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <BR><BR>
<input style="width:140px; height:35px" type="submit" value="Save Changes"><BR><BR><BR>
</form>
 
</div>
<? include "../../includes/footer.php" ?>