<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<?
 $sites = get_all_event_sites();
 $site = trim($_POST["site"]); 
 if ($site == ""){ $site = $_GET["site"];}
  $sites_details = get_event_site_details($site);
  if ($sites_details->vars["books"] != "-1"){
 	 
  $db_book = explode(",",$sites_details->vars["books"]);

  $array_book = array();
    foreach ($db_book as $db){
	     $array_book[$db] = $db;
	
	}

 }
 if ($sites_details->vars["leagues"] != "-1"){
	 
  $db_league = explode("_",$sites_details->vars["leagues"]);

  $array_league = array();
    foreach ($db_league as $le){
	     $array_league[$le] = $le;
	
	}

 }

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Sites </span>
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>
<form action="" method="post" >

 <select style="font-size:20px; height:35px" name ="site" onchange="this.form.submit()" >
  <option value ="">Select a Site</option>
  <? foreach ($sites as $st) {?>
     <option <? if ($site == ($st->vars["id"]) ) { echo ' selected="selected" '; }?> value="<? echo trim($st->vars["id"])?> "><? echo $st->vars["site"]?></option>
  <? } ?>
  
  </select>&nbsp;&nbsp;  <a href="add_sites.php" class="normal_link" rel="shadowbox;height=270;width=400">Add a Site</a>
 </form>
 <? if ($site != ""){ ?>
 <BR>
 <?

 
 $book_url = get_sites_target_books($site);
 $site_obj = get_event_site($site); 
 $books = get_all_events_books(1,0);
 $str_books="";
 for($i=1;$i <= $_POST["total"]+5;$i++ ){
     
	 if(isset($_POST["book_url_".$i])) {
		 $url = $_POST["book_url_".$i];
		 
		    if($url != "Add url target" ){
			  
			   if(isset($book_url[$i]->vars["id"])) {
			      $book_url[$i]->vars["target"]= $url;
				   $book_url[$i]->update(array("target"));
			   }else{
				   $book_new_url = new _sites_target_books();
				   $book_new_url->vars["site"] = $site;
				   $book_new_url->vars["book"] = $i;
				   $book_new_url->vars["target"]= $url;
				   $book_new_url->insert();
				   
				}
			 
			 }
		 
		 
	 }
	 
	 
	  if(isset($_POST["active_".$i])) {
		  $str_books .= $_POST["active_".$i].",";
		 }	 

 }
 $str_books = substr($str_books,0,-1);
 
 if (isset($_POST["total"])){
	 
	 if (is_null($sites_details)){

		 $sites_details = new _event_sites_details();
		 $sites_details->vars["site_id"] = $site;
		 $sites_details->vars["books"] = $str_books;
		 $sites_details->insert();
	 }
	 else{	

		  $sites_details->vars["books"] = $str_books;
		  $sites_details->update(array("books"));
	 }
	 
	 
	 $user_order = get_user_order_books("",$site_obj->vars["site"]);
  
  if (empty($user_order)){
	   $user_order = new _user_order_books();
	   $user_order->vars["user"] = "";
	   $user_order->vars["site"] = $site_obj->vars["site"];
	   $user_order->vars["order_book"] = $str_books;
	   $user_order->insert();
	   
	} else {
		
		$user_order->vars["order_book"] = $str_books;
	    $user_order->update(array("order_book"));
   
   }
	 
	 
	 
	 
	?><script> alert("Data Saved, Please Procced to Reorder your books");
        var x = BASE_URL . '/ck/widget_manager/sites.php?site=<? echo $site ?>';
	  	window.location.href = x;
      </script><?
	 
 }
 
 ?>
 <div>
  <span><strong>BOOKS</strong></span>
   <BR>
   <form method="post" >
 <input type="hidden" name="site" value="<? echo $site ?>" />
 <input type="hidden" name="total" value="<? echo count($books); ?>" />
 <BR>
 <table id="" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <? $x= 0; ?>
		  <? foreach ($books as $book) { 
		    if($i % 2){$style = "1";}else{$style = "2";} $i++;
			 
			 $value = $book_url[$book->vars["id"]]->vars["target"];
			 if (!$book_url[$book->vars["id"]]->vars["target"]){ $value = "Add url target";}
			 
			  ?>
			  <? if ($x == 0){ ?><tr><? } ?> 
              <? $x++; ?>
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
			  <input  <? if(isset($array_book[$book->vars["id"]])) { echo ' checked="checked" ';} ?> style="width:20px; height:25px" type="checkbox" name="active_<? echo $book->vars["id"]?>" value="<? echo $book->vars["id"]?>" />
              <img  title="<? echo $book->vars["book_name"]?>" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/images/books/<? echo $book->vars["small_name"]; ?>.jpg" />
              <input type="text" name="book_url_<? echo $book->vars["id"]?>" value="<? echo $value ?>"/>
              </td> 
		   <? if ($x==3) { ?></tr><? $x=0; }?>
                  

  <? } ?>
              		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <BR><BR>
<input style="width:140px; height:35px" type="submit" value="Save Changes"><BR><BR><BR>
</form>
    
  </div>
  
   <div>
  <span><strong>Default Order Book</strong></span>
 
    <iframe width="100%" height="900" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/leagues_widget/books_order.php?user=&domain=<? echo $site_obj->vars["site"]?>" scrolling="auto" frameborder="0" allowfullscreen></iframe> 
 
 </div>
  
  <BR>
  <?
  $leagues = get_all_event_leagues();
  
   if (isset($_POST["total_league"])){
   
	  for($i=1;$i <= $_POST["total_league"]+5;$i++ ){
      
	    if(isset($_POST["active_".$i])) {
		   $str_league .= $_POST["active_".$i]."_";
		 }	 

       }
      $str_league = substr($str_league,0,-1);
    	 
	 if (is_null($sites_details)){

		 $sites_details = new _event_sites_details();
		 $sites_details->vars["site_id"] = $site;
		 $sites_details->vars["leagues"] = $str_league;
		 $sites_details->insert();
	 }
	 else{	

		  $sites_details->vars["leagues"] = $str_league;
		  $sites_details->update(array("leagues"));
	 }
	?><script> alert("Data Saved");
        var x = BASE_URL . '/ck/widget_manager/sites.php?site=<? echo $site ?>';
	   	window.location.href = x;
      </script><?
	 
 }
   


  
  ?>
  
  <div>
  <span><strong>LEAGUES</strong></span>
    <form method="post" >
    <input type="hidden" name="site" value="<? echo $site ?>" />
    <input type="hidden" name="total_league" value="<? echo count($leagues); ?>" />
 <BR>
 <table id="" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <? $x= 0; ?>
		  <? foreach ($leagues as $row) { 
		    $img_name = str_replace(" ","",$row->vars["league"]);
		    if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <? if ($x == 0){ ?><tr><? } ?> 
              <? $x++; ?>
			  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
			  <input  <? if(isset($array_league[$row->vars["league"]])) { echo ' checked="checked" ';} ?> style="width:20px; height:25px" type="checkbox" name="active_<? echo $row->vars["id"]?>" value="<? echo $row->vars["league"]?>" />
              <img width="150px" height="30px" src="./images/<? echo trim($img_name) ?>.jpg" alt="" />
              </td> 
		   <? if ($x==5) { ?></tr><? $x=0; }?>
                  

  <? } ?>
              		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <BR>
         <span style="font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; alignment-adjust:central">
   If a Site wants to add another widget with diferents Leagues, it can be added using the "exclusive" variable in the inclusion (exc=NBA_NBCAA) else it will kept this default choise
 </span>
         <BR><BR>
<input style="width:140px; height:35px" type="submit" value="Save Changes"><BR><BR><BR>
</form>

 </div>
 
 
 
 <? }  ?>
</div>
<? include "../../includes/footer.php" ?>
