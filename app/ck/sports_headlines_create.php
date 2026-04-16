<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if($current_clerk->im_allow("main_brands_sports")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<title>Sports Headlines</title>
<script type="text/javascript" src="/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="/ck/includes/js/jquery-1.8.3.min.js"> </script>
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

function change_image_name(){
	var path,name,type;
	
	document.getElementById("btn").style.display = "none";	
	type =  document.getElementById("headline_type").value;	
	name = 	document.getElementById("rdm_name").value;
	//path = 'http://www.sportsbettingonline.ag/engine/sbo/images/headlines/pph/';
	path = 'https://vrbmarketing.b-cdn.net/headlines/pph/';
	document.getElementById("path_heads").innerHTML = path;
	
	if(type == 'm') { //mobile headlines
	   //path = 'http://www.sportsbettingonline.ag/mengine/sbo/images/headlines/';
	   path = 'https://vrbmarketing.b-cdn.net/mobile_headlines/';
	   name = name.replace("pph_", "m_");	  	      
	}else{ //pph headlines
	   //path = 'http://www.sportsbettingonline.ag/engine/sbo/images/headlines/pph/';
	   path = 'https://vrbmarketing.b-cdn.net/headlines/pph/';
	   name = name.replace("m_", "pph_");	  	
	}
	
	document.getElementById("type").value = type;
	document.getElementById("rdm_name").value = name;
	document.getElementById("f_name").value = name;
	document.getElementById("path_heads").innerHTML = path;	
		
	var obj = new Image();
		obj.src = path+name+".jpg";	
		
	if (obj.complete) {
		 show_btn();
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
	$headline = get_pph_sports_headline($_GET["id"]);
	
	$type  = $headline->vars["type"];
	
	if($type == "m"){ //Mobile Headlines
       //$path_headlines = "http://www.sportsbettingonline.ag/mengine/sbo/images/headlines/";
	   $path_headlines = "https://vrbmarketing.b-cdn.net/mobile_headlines/";
    } else { //PPH headlines
       //$path_headlines = "http://www.sportsbettingonline.ag/engine/sbo/images/headlines/pph/";
	   $path_headlines = "https://vrbmarketing.b-cdn.net/headlines/pph/";	  		  	
    }
}
?>
<span class="page_title"><? if($update) { echo "Edit ";} else { echo "Add New ";}?>Sports Headlines</span><br /><br />
<?
 include "includes/print_error.php";
 
if ($update){
	echo "Change Image:<br />";
	$name  = $headline->vars["image"];
	$brand = $headline->vars["brand"];		
	$ext = ".jpg";	
	?>
	<a target="_blank" href="<? echo $path_headlines; ?><? echo $name.$ext; ?>" title="Click to see real size">
	 <img alt="Click to see real size" style="width: 400px;height: 100px;" src="<? echo $path_headlines; ?><? echo $name.$ext; ?>" />
	</a>
	<?      
	
}else{
  $name = "pph_".rand_str();
  $type = "b";
}
?>
<BR>

<strong>Step #1</strong> : Choose the headline type :	   

    <select name="headline_type" id="headline_type" onchange="change_image_name();">
        <option <? if ($headline->vars["type"] == 'b'){ echo "selected"; } ?>  value="b">Big</option>        
       <?php /*?> <option <? if ($headline->vars["type"] == 'n'){ echo "selected"; } ?>  value="n">Normal</option><?php */?>        
        <option <? if ($headline->vars["type"] == 'm'){ echo "selected"; } ?>  value="m">Mobile</option>       
   </select><br /><br />
<strong>Step #2</strong> : Rename the Image with the following name : <input id="rdm_name" type="text" readonly="readonly" value="<? echo $name ?>"><br /><br />   
<strong>Step #3</strong> : Upload through FTP :<input onchange="change_image_name();" style="width: 30px;height: 30px; position: absolute; margin-top: -8px;" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br /><br /><span style="font-size:12px">(Check when the image has been already Uploaded in ("<span id="path_heads"><? if ($update) { echo $path_headlines; } else { echo 'https://vrbmarketing.b-cdn.net/headlines/pph/';} ?>
</span>")</span><br /><br />

<form action="process/actions/insert_sports_headlines_action.php" method="post">
	<? if ($update){ ?>
    	<input id="update" type="hidden" name="update" value="<? echo $headline->vars["id"] ?>">
    <? } ?>
    
    <input id="type" type="hidden" name="type" value="<? echo $type; ?>">
    
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
    <option <? if ($hour== $oparts[0]){ echo "selected"; } ?>  value="<? echo $hour?>" ><? echo $hour ?> </option>
    <? } ?>
    </select> : 
    <select  name="start_minute">
    <? foreach ($minutes as $minute){ ?>
    <option <? if ($minute== $oparts[1]){ echo "selected"; } ?> value="<? echo $minute?>" ><? echo $minute ?> </option>
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
    
    <strong id="url_title" <? echo $display; ?>>Url:</strong>
    <input type="text" name="url" value="<? echo $headline->vars["url"] ?>" size="100"><BR><BR>
    <strong>Alt Text:</strong>
    <input type="text" name="alt_text" value="<? echo $headline->vars["alt_text"] ?>" size="100"><br /><br /><br /> 
    
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