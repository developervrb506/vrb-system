<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("main_brands_sports")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Main Brands Sports Headlines</title>
<script type="text/javascript" src="/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>

<script type="text/javascript" src="/process/js/jquery.js"> </script>
 
<script type="text/javascript">
<!--

function delete_headline(id){
	if(confirm("Are you sure you want to DELETE this entry from the system?")){
		document.getElementById("idel").src = "/ck/process/actions/insert_main_brands_sports_headlines_action.php?id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
//-->
</script>

<script>
function submit_frm(){
  document.forms["frm_brand"].submit();
}

</script>

</head>
<body>
<? $page_style = " width:1200px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Main Brands Sports Headlines / Banners</span><br /><br />

<input type="button" value="Run job" name="btn_run_job" id="btn_run_job">
<br /><br />
<div id="message_run_job"></div>
<br /><br />

<?
  if (isset($_POST["brand"])){
    $brand = $_POST["brand"];
  } else { $brand = "sbo"; }
  
  if (isset($_POST["type"])){
	  
    $type = $_POST["type"];
		
	/*if($type == "he"){
	  $ext = ".jpg";	  
	}else{
	  $ext = ".gif";	
	}*/
	
	if($type == "he" && $brand != "bitbet"){
	  $ext = ".jpg";	  
	}elseif($type == "he" && $brand == "bitbet"){
	  $ext = ".png";	
	}else{
	  $ext = ".gif";	
	}
		
  } else { $type = "he"; $ext = ".jpg";}  
?>

<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
<a href="/ck/main_brands_sports_headlines_create.php">Add a New</a><br /><br />

<form method="post" id="frm_brand" name="frm_brand">

BRAND: <select name="brand" onchange="submit_frm();">
<option <? if ($brand == "sbo"){ echo ' selected="selected" '; } ?> value="sbo">SBO</option>
<?php /*?><option <? if ($brand == "owi"){ echo ' selected="selected" '; } ?> value="owi">OWI/HRB</option><?php */?>
<option <? if ($brand == "bitbet"){ echo ' selected="selected" '; } ?> value="bitbet">BITBET</option>
<option <? if ($brand == "sgi"){ echo ' selected="selected" '; } ?> value="sgi">SGI</option>
</select>
<br /><br />
TYPE: <select name="type" onchange="submit_frm();">
<option <? if ($type == "he"){ echo ' selected="selected" '; } ?> value="he">HEADLINE</option>
<option <? if ($type == "bh"){ echo ' selected="selected" '; } ?> value="bh">BANNER HORIZONTAL</option>
<option <? if ($type == "bv"){ echo ' selected="selected" '; } ?> value="bv">BANNER VERTICAL</option>
</select>

</form>
<br /><br />

<?
$headlines = get_all_main_brands_sports_headline($brand,$type);

if(!is_null($headlines)) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center"><strong>ID</strong></th>
    <td class="table_header" align="center"><strong>Image</strong></th>
	<td class="table_header" align="center"><strong>Name</strong></th>
    <td class="table_header" align="center"><strong>Type</strong></th>    
    <td class="table_header" align="center" nowrap="nowrap"><strong>Start Time</strong></th>
    <td class="table_header" align="center"><strong>End Time</strong></th>
    <td class="table_header" align="center"><strong>Priority</strong></th>
    <td class="table_header" align="center"></th> 
    <td class="table_header" align="center"></th>   
  </tr>

   <?   
   foreach( $headlines as $hd ){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   $type = $hd->vars["type"];
   if ($type == "he") {
	 $type = "Headline";	 
   }elseif ($type == "bh") {
	 $type = "Banner Horizontal";	   
   }elseif ($type == "bv") {
	 $type = "Banner Vertical";	  
   }
   ?>
  <tr id="tr_<? echo $hd->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $hd->vars["id"]; ?></th>        
		<th class="table_td<? echo $style ?>"><a target="_blank" href="https://vrbmarketing.b-cdn.net/headlines/<? echo $hd->vars["image"]; ?><? echo $ext ?>" title="Click to see real size"><img alt="Click to see real size" style="width: 400px;height: 100px;" src="https://vrbmarketing.b-cdn.net/headlines/<? echo $hd->vars["image"]; ?><? echo $ext ?>" /></a></th>
        <th class="table_td<? echo $style ?>"><? echo $hd->vars["image"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $type; ?></th>
        <th class="table_td<? echo $style ?>" nowrap="nowrap"><? echo  $hd->vars["start_time"]; ?></th>
        <th class="table_td<? echo $style ?>" nowrap="nowrap"><? echo $hd->vars["end_time"]; ?></th>
        <th class="table_td<? echo $style ?>" nowrap="nowrap">
		<select class="priority" name="priority_<? echo $hd->vars["id"] ?>" id="priority_<? echo $hd->vars["id"] ?>" style="width:50px;">
            <? for ($j = 1; $j <= 30; $j++){ ?>
           <option <? if ($j == $hd->vars["priority"]){ echo "selected"; } ?>  value="<? echo $j; ?>"><? echo $j; ?></option>
    <? } ?>
         </select>         
         <div class="message_container_priority" id="success_saved_priority_<? echo $hd->vars["id"]; ?>"></div>
        </th>
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="/ck/main_brands_sports_headlines_create.php?id=<? echo $hd->vars["id"] ?>">Edit</a></th>  
        <th class="table_td<? echo $style ?>"><a class="normal_link" href="javascript:delete_headline(<? echo $hd->vars["id"] ?>,'delete')">Delete</a>
        </th> 
  </tr>
<? } ?>
 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
 </tr>
</table>	
<BR>
<? } else { 

    $html='No Data Found';
	echo $html;
}

?>
</div>
<? include "../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>

<script>	
$(document).on("change", ".priority", function(e){
        		
		e.preventDefault();
		var id, priority_select_list, priority;
		
		priority_select_list = $(this);
		id = priority_select_list.attr("id");		
		id = id.split('_');
	    id = id[1];
		
		priority = $("#priority_"+id).val();					
		
        $.ajax({
            type: "POST",
            url: "/ck/process/actions/update_priority_main_brand_sport_headline.php",
            data: "id="+id+"&priority="+priority,
            success: function(data) {	    
				 $('#success_saved_priority_'+id).html('Saved<br>successfully');
				 $('#success_saved_priority_'+id).fadeIn(2000);
				 $('#success_saved_priority_'+id).fadeOut(2000);
            },
            error: function(err){                
				$('#success_saved_priority_'+id).html(err);
				$('#success_saved_priority_'+id).fadeIn(2000);
				$('#success_saved_priority_'+id).fadeOut(2000);
            }
        });	
		
});	

$(document).on("click", "#btn_run_job", function(e){
        		
		e.preventDefault();
			
        $.ajax({
            type: "POST",
            url: "/ck/process/actions/run_sports_headlines.php",
            data: "",
            success: function(data) {		     
				 $('#message_run_job').html('The job has been executed successfully');
				 $('#message_run_job').fadeIn(3000);
				 $('#message_run_job').fadeOut(3000);			 
            },
            error: function(err){                
				$('#message_run_job').html(err);
				$('#message_run_job').fadeIn(3000);
				$('#message_run_job').fadeOut(3000);
            }
        });	
		
});	
</script>