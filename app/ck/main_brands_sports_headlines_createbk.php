<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("main_brands_sports")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<title>Sports Headlines</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.3.min.js"> </script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
 
<script type="text/javascript">
function show_btn(){
	document.getElementById("btn").style.display = "block";
}

function check_image_type(type){
	
	var ext;
		
	if (type == 'he' || type == ''){
		ext = '.jpg';
		//document.getElementById("url_title").style.display = "none";
		//document.getElementById("url").style.display = "none";
		//document.getElementById("alt_text_title").style.display = "none";
		//document.getElementById("alt_text").style.display = "none";
		//document.getElementById("url").value = '';
		//document.getElementById("alt_text").value = '';  
	}else{		
		ext = '.gif';
		document.getElementById("url_title").style.display = "block";
		document.getElementById("url").style.display = "block";
		document.getElementById("alt_text_title").style.display = "block";
		document.getElementById("alt_text").style.display = "block";
	}
	
	document.getElementById("img_ext").value = ext;	
}

function check_image(){
	
	var ext  = document.getElementById("img_ext").value;		
	var name = document.getElementById("rdm_name").value;
	
	if (ext == '') { //Default Headline
		ext = '.jpg';
	}
						
	var obj = new Image();
		//obj.src = "http://www.sportsbettingonline.ag/engine/sbo/images/headlines/"+name+ext;
		obj.src = "https://vrbmarketing.b-cdn.net/headlines/"+name+ext;		
		
	if (obj.complete) {		
	    show_btn();
	} else {
		alert('Please upload First the image before mark the check');		
	}
}
</script>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
$hours   = get_all_hours();
$minutes = get_all_minutes();

$update=false;
if (isset($_GET["id"])){
	$update = true;
	$headline = get_main_brands_sports_headline($_GET["id"]);
}
?>
<span class="page_title"><? if($update) { echo "Edit ";} else { echo "Add New ";}?> Main Brands Sports Headlines / Banners</span><br /><br />
<?
include "includes/print_error.php";

if ($update){
	echo "Change Image:<br />";
	$name  = $headline->vars["image"];
	$brand = $headline->vars["brand"];
	$type  = $headline->vars["type"];
	
	/*if ($type == "he") {
	   $ext = ".jpg";
	}else {
	   $ext = ".gif";	
	}*/
	
	if($type == "he" && $brand != "bitbet"){
	  $ext = ".jpg";	  
	}elseif($type == "he" && $brand == "bitbet"){
	  $ext = ".png";	
	}else{
	  $ext = ".gif";	
	}		
	?>
	<a target="_blank" href="https://vrbmarketing.b-cdn.net/headlines/<? echo $name.$ext; ?>" title="Click to see real size">
	 <img alt="Click to see real size" style="width: 400px;height: 100px;" src="https://vrbmarketing.b-cdn.net/headlines/<? echo $name.$ext; ?>" />
	</a>
	<?	
}else{
    $name = "main_".rand_str();
    $brand = "sbo";    
}
?>
<BR><BR>
<form action="process/actions/insert_main_brands_sports_headlines_action.php" method="post">
<strong>Step 1:</strong> Choose Brand:
     <select name="brand">
		<option <? if ($brand == "sbo"){ echo ' selected="selected" '; } ?> value="sbo">SBO</option>
		<option <? if ($brand == "owi"){ echo ' selected="selected" '; } ?> value="owi">OWI/HRB</option>
        <option <? if ($brand == "bitbet"){ echo ' selected="selected" '; } ?> value="bitbet">BITBET</option>
        <option <? if ($brand == "sgi"){ echo ' selected="selected" '; } ?> value="sgi">SGI</option>
	</select><BR><BR>
<strong>Step 2:</strong> Choose Type: <strong>Headlines must be .jpg files and banners .gif files</strong>
<br /><br />
     <select name="type" onchange="check_image_type(this.value);">        
        <option <? if ($type == "he"){ echo ' selected="selected" '; } ?> value="he">HEADLINE</option>
        <option <? if ($type == "bh"){ echo ' selected="selected" '; } ?> value="bh">BANNER HORIZONTAL</option>
        <option <? if ($type == "bv"){ echo ' selected="selected" '; } ?> value="bv">BANNER VERTICAL</option>        
</select>
<p><strong>Step 3</strong> : Rename the Image with the following name : <input id="rdm_name" type="text" readonly="readonly" value="<? echo $name ?>"></p>
<p><strong>Step 4</strong> : Upload through FTP :<input onchange="check_image();" style="width: 30px;height: 30px; position: absolute; margin-top: -8px;" type="checkbox"><br /><br /><strong>(Check when the image was already Uploaded in the following path: https://vrbmarketing.b-cdn.net/headlines/)</strong></p><BR><BR>

	<? if ($update){ ?>
    	<input id="update" type="hidden" name="update" value="<? echo $headline->vars["id"] ?>">
    <? } ?>    
    <input id="img_ext" type="hidden" name="img_ext" value="">    
    <input id="f_name" type="hidden" name="image" value="<? echo $name ?>">
    <? 
     $time_open = date("g:i:A", strtotime($headline->vars["start_time"]));
     $oparts = explode(":",$time_open); 
     
     $time_close = date("g:i:A", strtotime($headline->vars["end_time"]));
     $cparts = explode(":",$time_close); 
     
     if (!$update){
      $date_start = date("Y-m-d");
      $date_end = date("Y-m-d");	 			 
     }
     else{
      $date_start = date("Y-m-d", strtotime($headline->vars["start_time"]));
      $date_end = date("Y-m-d", strtotime($headline->vars["end_time"]));	  
     }	 
    ?>      
      
    <strong>Start Time:</strong><BR>
    <input id="from" type="text" name="from" value="<? echo $date_start ?>" readonly="readonly">
    <select name="start_hour">
    <? foreach ($hours as $hour){ ?>
    <option <? if ($hour== $oparts[0]){ echo "selected"; } ?>  value="<? echo $hour ?>" ><? echo $hour ?> </option>
    <? } ?>
    </select> : 
    <select  name="start_minute">
    <? foreach ($minutes as $minute){ ?>
    <option <? if ($minute== $oparts[1]){ echo "selected"; } ?> value="<? echo $minute ?>" ><? echo $minute ?> </option>
    <? }  ?>
    </select>
    <select  name="start_data" >
    <option <? if ($oparts[2] == "AM"){ echo "selected"; } ?> value="AM" >AM</option>
    <option <? if ($oparts[2] == "PM" ){ echo "selected"; } ?> value="PM" >PM</option> 
    </select>              
              
    <BR>
    <strong>Example</strong>: 08 : 30 AM<br /><br />
                  
    <strong>End Time</strong>
    <BR>
    <input id="to" type="text" name="to" value="<? echo $date_end ?>" readonly="readonly">
    <select  name="end_hour">
    <? foreach ($hours as $hour){ ?>
    <option <? if ($hour== $cparts[0]){ echo "selected"; } ?>  value="<? echo $hour?>" ><? echo $hour ?> </option>
    <? } ?>
    </select> : 
    <select  name="end_minute">
    <? foreach ($minutes as $minute){ ?>
    <option <? if ($minute== $cparts[1]){ echo "selected"; } ?> value="<? echo $minute?>" ><? echo $minute ?> </option>
    <? }  ?>
    </select>
    <select name="end_data" >
    <option <? if ($cparts[2] == "AM"){ echo "selected"; } ?> value="AM" >AM</option>
    <option <? if ($cparts[2] == "PM" ){ echo "selected"; } ?> value="PM" >PM</option> 
    </select>
    <BR>
    <strong>Example</strong>: 09 : 30 PM<br /><br />
    
    <? 
	if ($update and $type != 'he'){ 
	   $display = 'style = "display:block"';
	} else {
	   //$display = 'style = "display:none"';	
	}
	?>
    
    <strong id="url_title" <? echo $display; ?>>Url:</strong>
    <input <? echo $display; ?> id="url" type="text" name="url" value="<? echo $headline->vars["url"] ?>" size="100"><BR><BR>
    <strong id="alt_text_title" <? echo $display; ?>>Alt Text:</strong>
    <input <? echo $display; ?> id="alt_text" type="text" name="alt_text" value="<? echo $headline->vars["alt_text"] ?>" size="100"><br /><br />
       
    <strong>Priority:</strong><BR>
    
    <select name="priority" style="width:50px;">
    <? for ($i = 1; $i <= 30; $i++){ ?>
    <option <? if ($i == $headline->vars["priority"]){ echo "selected"; } ?>  value="<? echo $i; ?>"><? echo $i; ?></option>
    <? } ?>
    </select>
    <br /><br /><br /> 
         
    <input id="btn" style="width: 120px; <? if(!$update) { ?>display:none<? } ?>" type="submit" value="Save" />
</form>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>

</div>
<? include "../includes/footer.php" ?>

<? } else { echo "ACCESS DENIED"; } ?>