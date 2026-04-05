<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Events leagues</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
 function reload(color,site){
	//alert(color); 
 var url = window.location.href;    
   if (url.indexOf('?') > -1){
   url += '&color='+color+'&site='+site;
}else{
   url += '?color='+color+'&site='+site;
}
window.location.href = url;
 
 }
 
 function reload_banner(banner,site,color){
	//alert(color); 
 var url = window.location.href;    
   if (url.indexOf('?') > -1){
   url += '&color='+color+'&site='+site+'&banner='+banner;
}else{
   url += '?color='+color+'&site='+site+'&banner='+banner;
}
window.location.href = url;
 
 }

</script>
<script type="text/javascript">
function copy_code(){
	document.getElementById('code_field').focus();
	document.getElementById('code_field').select();
}
</script>

<script type="text/javascript">
function save_book_url(site, book){
	var content = document.getElementById("book_url_"+book).value;
	//alert(document.getElementById("book_url_"+book).value);
	
	document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/site_book_target_action.php?site="+site+"&book="+book+"&content="+content;
	document.getElementById("book_url_"+book).style.border = "solid 1px green"
	//window.location	= "http://localhost:8080/ck/process/actions/site_book_target_action.php?site="+site+"&book="+book+"&content="+content;
	
}
</script>

</head>
<body>
<? $page_style = " width:1600px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<?
 $books = get_all_events_books(1,0);
 $sites = get_all_event_sites();
 $site = trim($_POST["site"]); 
 if ($site == ""){ $site = $_GET["site"];}
  
 if (isset($_GET["aid"])) { $aid = $_GET["aid"]; } else { $aid = 999;}
 $book_url = get_sites_target_books($site);
 $sites_details = get_event_site_details($site);
  if ($sites_details->vars["books"] != "-1"){
 	 
  $db_book = explode(",",$sites_details->vars["books"]);
  }
  
  $book_id_target= array();
  foreach($db_book as $b){
	  $book_id_target[$b]=$b;
  }
  
  
  
?>
<div class="page_content" style="padding-left:50px; width:1200px">
<span class="page_title">Widget Creation for Site</span><br /><br />
<div>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>
<div align="right"><span ><a href="http://localhost:8080/ck/widget_manager/events_leagues.php">Back</a></span></div>
<form action="" method="post" >

 <select style="font-size:20px; height:35px" name ="site" onchange="this.form.submit()" >
  <option value ="">Select a Site</option>
  <? foreach ($sites as $st) {?>
     <option <? if ($site == ($st->vars["id"]) ) { echo ' selected="selected" '; }?> value="<? echo trim($st->vars["id"])?> "><? echo $st->vars["site"]?></option>
  <? } ?>
  
  </select>&nbsp;&nbsp;  <a href="add_sites.php" class="normal_link" rel="shadowbox;height=270;width=400">Add a Site</a>
 </form>
 <? if ($site != ""){
   if ($_GET["color"]== "") { $color = "red"; } else { $color = $_GET["color"]; } 
   if ($_GET["banner"]== "") { $banner = "0"; } else { $banner = $_GET["banner"]; } 
    if ($_GET["h"]== "") { $h = "800"; } else { $h = $_GET["h"]; } ?>
   <BR><BR>
   <form action="" method="get" >
    <input type="hidden" value="<? echo  $color ?>" name="color">
    <input type="hidden" value="<? echo  $site ?>" name="site">
  &nbsp;&nbsp;&nbsp; Height:<input type="number" value="<? echo  $h ?>" name="h" min="600" max="1200"><input type="submit" value="Generate">
  </form> 
  <? 
  $site_obj = get_event_site($site); 
  
  if ($banner){
  
 
   $code = ' <iframe width="100%" height="'.$h.'" id="widget_iframe" scrolling="no" frameborder="0" allowfullscreen></iframe><BR>
            <script type="text/javascript">document.getElementById("widget_iframe").src = "http://lines.sportsbettingonline.ag/utilities/process/stats/widget/leagues_widget/main.php?banner='.$banner.'&color='.$color.'&height='.($h-320).'&user=&domain='.$site_obj->vars["site"].'&aid='.$aid.'&bkurl="+encodeURI(location.href);</script>';
 
 
  }
  else{
	
	
	$code = ' <iframe width="100%" height="'.$h.'" id="widget_iframe" scrolling="no" frameborder="0" allowfullscreen></iframe><BR>
            <script type="text/javascript">document.getElementById("widget_iframe").src = "http://lines.sportsbettingonline.ag/utilities/process/stats/widget/leagues_widget/main.php?color='.$color.'&height='.($h-250).'&user=&domain='.$site_obj->vars["site"].'&bkurl="+encodeURI(location.href);</script>';
			  
  }
  
  
  
  
  
 ?>
 <br />
&nbsp;&nbsp;&nbsp; RED <input type="radio" <? if ($color == "red") { echo ' checked="fchecked" '; }?> value="red" name ="color" onchange="reload(this.value,'<? echo $site ?>')" />  
&nbsp;&nbsp;BLUE <input  <? if ($color == "blue") { echo ' checked="checked" '; }?>type="radio" value="blue" name ="color" onchange="reload(this.value,'<? echo $site ?>')" />

&nbsp;&nbsp;GREEN <input  <? if ($color == "green") { echo ' checked="checked" '; }?>type="radio" value="green" name ="color" onchange="reload(this.value,'<? echo $site ?>')" />

&nbsp;&nbsp;YELLOW <input  <? if ($color == "yellow") { echo ' checked="checked" '; }?>type="radio" value="yellow" name ="color" onchange="reload(this.value,'<? echo $site ?>')" />
 <br /><br />
 
 <BR>
  <div style='width: 75%; min-height:53px; max-height:400px; overflow:scroll;'>
  <span> These are the Books selected for this Site if you want to add a URL just add it and press "Save"</span><BR>
   <span> If you want to Remove a URL just leave it empty and press "Save" </span><BR><BR>
  <table id="" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <? $x= 0; ?>
		  <? foreach ($books as $book) { 
		    
			if (isset($book_id_target[$book->vars["id"]])){
				if($i % 2){$style = "1";}else{$style = "2";} $i++;
				 $style = "1";
				 $value = $book_url[$book->vars["id"]]->vars["target"];
				 if (!$book_url[$book->vars["id"]]->vars["target"]){ $value = "Add url target";}
				 
				  ?>
				  <? if ($x == 0){ ?><tr><? } ?> 
				  <? $x++; ?>
				  <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;">
				   <div>
                   <img  title="<? echo $book->vars["book_name"]?>" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/images/books/<? echo $book->vars["small_name"]; ?>.jpg" />
				  
                  <input type="text" style="width:250px" name="book_url_<? echo $book->vars["id"]?>" id="book_url_<? echo $book->vars["id"]?>" value="<? echo $value ?>"/>
				  <input type="button" name="save" value="Save" onclick="save_book_url('<? echo $site ?>','<? echo $book->vars["id"] ?>')" />
                  <div>
                  </td> 
			   <? if ($x==2) { ?></tr><? $x=0; }?>
                
 			<? } ?>
        <? } ?>
              		
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <BR><BR>
 </div>       
 <br /><br />
 
 
 
 <div style='width: 75%; min-height:53px; max-height:400px; overflow:scroll;'>
  
 <?


 $banners = get_all_event_banners();
  
?> 

 <table id="" width="90%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td width="100"  class="table_header" align="center" ></td>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Banner</td>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Size</td> 
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Link</td> 
			
          
		 </tr>  
		<tr>
                <td class="table_td1" style="font-size:12px;"><input type="radio" <? if ($banner == 0) { echo ' checked="fchecked" '; }?> value="0" name ="banner_0" onchange="reload_banner(this.value,'<? echo $site ?>','<? echo $color ?>')" /></td>
                <td class="table_td1" style="font-size:16px;"><strong>-----------------------  NO BANNER  -----------------------</strong></td>
                 <td class="table_td1" style="font-size:12px;">-------</td>
                 <td class="table_td1" style="font-size:12px;">-------</td>
        </tr>      
		  <? foreach ($banners as $bn) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <input type="radio" <? if ($banner == $bn->vars["id"]) { echo ' checked="fchecked" '; }?> value="<? echo $bn->vars["id"] ?>" name ="banner_<? echo $bn->vars["id"] ?>" onchange="reload_banner(this.value,'<? echo $site ?>','<? echo $color ?>')" /></td>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <img width="500px" height="50px" src="<? echo $bn->vars["banner"]; ?>">
			   
			   
               </td>
                <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <? echo $bn->vars["size"]; ?>
               </td>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <? echo $bn->vars["link"]; ?>
               </td>
			  
			 </tr>
         <? } ?>    
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        
        <BR><BR> 
 
 </div><BR><BR> 
 
 
 <div>
   <strong>AFFILIATE</strong>&nbsp;&nbsp; 
   <input type="text" style="width: 50px;" readonly="readonly" value="<? echo $_GET["aid"]?>">
   &nbsp;&nbsp;
   <a href="http://localhost:8080/ck/affiliates/partners_search_ids_box.php?site=<? echo $site ?>&<? echo $_SERVER['QUERY_STRING'];?>" class="normal_link" rel="shadowbox;height=270;width=400">Add Affiliate</a>
   <BR>
   ( Affiliate is Optional, it used to track the banner )
   <BR /><BR />
 </div>
 
 
 <strong>Code:</strong><br />
<textarea name="code_field" id="code_field" cols="100" rows="10" readonly="readonly" id="code_field" onclick="copy_code(this)"><? echo $code ?> </textarea><br />
<input type="button" value="Copy Code" onclick="copy_code();" />
  <br /><br />
 <strong>Preview:</strong><br />
   <? echo $code ?>
 <? }?>
 
 
</div>



</div>
<? include "../../includes/footer.php" ?>