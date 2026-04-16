<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>


input[type="checkbox"]{
  border: 1px solid #333;
  content: "\00a0";
  display: inline-block;
  height: 20px;
  margin: 0 .25em 0 0;
  padding: 0;
  vertical-align: top;
  width: 20px;
   background:#900;
   background-color:#0C3
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script>
  function change_wind(type,id){
	
	 if (type == 'g'){
		 document.getElementById("r_"+id).checked = false; 
	 }
     if (type == 'r'){
		 document.getElementById("g_"+id).checked = false; 
	 }
	 
}

 function change_color(type,id){
	
	 if (type == 'g'){
		 document.getElementById(id+"_r").checked = false; 
	 }
     if (type == 'r'){
		 document.getElementById(id+"_g").checked = false; 
	 }
	 
}

</script>   
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Stadium Data </span><br />
<br />
<? $stadium = get_baseball_stadium($_GET["sid"]); ?>
<? $wind = get_baseball_wind_direction(); ?>
<? $g_wind = explode(",",$stadium->vars["wind_direction_green"])?>
<? $r_wind = explode(",",$stadium->vars["wind_direction_red"])?>
<?


?>
<div class="form_box">
  <form method="post" action="process/actions/stadium_update_action.php" >
    <table width="85%"  border="0" cellspacing="3" cellpadding="3">
    <tr>
        <td>&nbsp;&nbsp;&nbsp;Time:</td>
        <td>
        
		<? 
		  $cond = explode("_",$stadium->vars["time"]);
		?>
        <select id="time"  name="time" >
              <option <? if($cond[0] == 0){ echo ' selected="selected" ';}?> value="0">DAY</option>
              <option <? if($cond[0] == 1){ echo ' selected="selected" ';}?>  value="1">NIGTH</option>
        </select>
             <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','12');" type="checkbox" style="background-color:#0C0; width:25px" id="12_g" name="time_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','12');" type="checkbox" style="background-color:#F30; width:25px" id="12_r" name="time_col_r"><label style="color:#F00"> <strong>RED</strong></label>
        </td>        
      </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;Temp:</td>
        <td>
        <input name="temp" type="number" style="width:55px" value="<? echo $stadium->vars["temp"] ?>" step=".01">
		<? 
		  $cond = explode("_",$stadium->vars["temp_cond"]);
		?>
        <select id="temp"  name="temp_cond" >
              <option <? if($cond[0] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($cond[0] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
             <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','11');" type="checkbox" style="background-color:#0C0; width:25px" id="11_g" name="temp_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','11');" type="checkbox" style="background-color:#F30; width:25px" id="11_r" name="temp_col_r"><label style="color:#F00"> <strong>RED</strong></label>
        </td>        
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Humidity:</td>
        <td>
        <input name="humidity" type="number" style="width:55px" value="<? echo $stadium->vars["humidity"] ?>" step=".01">
		<? 
		  $cond = explode("_",$stadium->vars["humidity_cond"]);
		?>
        <select id="hum"  name="humidity_cond" >
              <option <? if($cond[0] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($cond[0] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
             <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','1');" type="checkbox" style="background-color:#0C0; width:25px" id="1_g" name="humidity_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','1');" type="checkbox" style="background-color:#F30; width:25px" id="1_r" name="humidity_col_r"><label style="color:#F00"> <strong>RED</strong></label>
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Wind Speed:</td>
        <td>
        <input name="wind_speed" type="number" style="width:55px" value="<? echo $stadium->vars["wind_speed"] ?>" step=".01">
        <? 
		  $cond = explode("_",$stadium->vars["wind_speed_cond"]);
		?>
		<select name="wind_speed_cond" >
              <option <? if($stadium->vars["wind_speed_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["wind_speed_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
         <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','2');" type="checkbox" style="background-color:#0C0; width:25px" id="2_g" name="wind_speed_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','2');" type="checkbox" style="background-color:#F30; width:25px" id="2_r" name="wind_speed_col_r"><label style="color:#F00"> <strong>RED</strong></label>    
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Wind Gust:</td>
        <td><input name="wind_gust" type="number" style="width:55px" value="<? echo $stadium->vars["wind_gust"] ?>" step=".01">
        <? 
		  $cond = explode("_",$stadium->vars["wind_gust_cond"]);
		?>
		<select name="wind_gust_cond" >
              <option <? if($stadium->vars["wind_gust_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["wind_gusty_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
          <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','3');" type="checkbox" style="background-color:#0C0; width:25px" id="3_g" name="wind_gust_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','3');" type="checkbox" style="background-color:#F30; width:25px" id="3_r" name="wind_gust_col_r"><label style="color:#F00"> <strong>RED</strong></label>   
            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Air Pressure:</td>
        <td><input name="air_pressure" type="number" style="width:55px" value="<? echo $stadium->vars["air_pressure"] ?>" step=".01">
        <? 
		  $cond = explode("_",$stadium->vars["air_pressure_cond"]);
		?>
			<select name="air_pressure_cond" >
              <option <? if($stadium->vars["air_pressure_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["air_pressure_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
		 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','4');" type="checkbox" style="background-color:#0C0; width:25px" id="4_g" name="air_pressure_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','4');" type="checkbox" style="background-color:#F30; width:25px" id="4_r" name="air_pressure_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Dew Point:</td>
        <td><input name="dew_point" type="number" style="width:55px" value="<? echo $stadium->vars["dew_point"] ?>" step=".01">
        <? 
		  $cond = explode("_",$stadium->vars["dew_point_cond"]);
		?>
			<select name="dew_point_cond" >
              <option <? if($stadium->vars["dew_point_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["dew_point_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
			 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','5');" type="checkbox" style="background-color:#0C0; width:25px" id="5_g" name="dew_point_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','5');" type="checkbox" style="background-color:#F30; width:25px" id="5_r" name="dew_point_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Dry Air:</td>
        <td><input name="dry_air" type="number" style="width:70px" value="<? echo $stadium->vars["dry_air"] ?>" step=".0001">
        <? 
		  $cond = explode("_",$stadium->vars["dry_air_cond"]);
		?>
			<select name="dry_air_cond" >
              <option <? if($stadium->vars["dry_air_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["dry_air_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
			 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','6');" type="checkbox" style="background-color:#0C0; width:25px" id="6_g" name="dry_air_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','6');" type="checkbox" style="background-color:#F30; width:25px" id="6_r" name="dry_air_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Vapor Pressure:</td>
        <td><input name="vapor_pressure" type="number" style="width:70px" value="<? echo $stadium->vars["vapor_pressure"] ?>" step=".0001">
        <? 
		  $cond = explode("_",$stadium->vars["vapor_pressure_cond"]);
		?>
			<select name="vapor_pressure_cond" >
              <option <? if($stadium->vars["vapor_pressure_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["vapor_pressure_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
			 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','7');" type="checkbox" style="background-color:#0C0; width:25px" id="7_g" name="vapor_pressure_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		 <input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','7');" type="checkbox" style="background-color:#F30; width:25px" id="7_r" name="vapor_pressure_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Moist Air:</td>
        <td><input name="moist_air" type="number" style="width:70px" value="<? echo $stadium->vars["moist_air"] ?>" step=".0001">
        <? 
		  $cond = explode("_",$stadium->vars["moist_air_cond"]);
		?>
		<select name="moist_air_cond" >
              <option <? if($stadium->vars["moist_air_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["moist_air_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
		 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','8');" type="checkbox" style="background-color:#0C0; width:25px" id="8_g" name="moist_air_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		<input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','8');" type="checkbox" style="background-color:#F30; width:25px" id="8_r" name="moist_air_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Air Density:</td>
        <td><input name="aird" type="number" style="width:70px" value="<? echo $stadium->vars["aird"] ?>" step=".01">
        <? 
		  $cond = explode("_",$stadium->vars["aird_cond"]);
		?>
		<select name="aird_cond" >
              <option <? if($stadium->vars["aird_cond"] == 0){ echo ' selected="selected" ';}?> value="0">DOWN</option>
              <option <? if($stadium->vars["aird_cond"] == 1){ echo ' selected="selected" ';}?>  value="1">UP</option>
            </select>
		 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','13');" type="checkbox" style="background-color:#0C0; width:25px" id="13_g" name="aird_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		<input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','13');" type="checkbox" style="background-color:#F30; width:25px" id="13_r" name="aird_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
     <? if($stadium->vars["has_roof"]){ ?>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;Roof</td>
        <td>
        <? 
		  $cond = explode("_",$stadium->vars["roof_cond"]);
		?>
		<select name="roof_cond" >
              <option <? if($stadium->vars["roof"] == 1){ echo ' selected="selected" ';}?> value="1">OPEN</option>
              <option <? if($stadium->vars["roof"] == 0){ echo ' selected="selected" ';}?>  value="0">CLOSE</option>
            </select>
		 <input value="g" <? if ($cond[1] == "g"){ echo 'checked="checked" ';}?>  onchange="change_color('g','9');" type="checkbox" style="background-color:#0C0; width:25px" id="9_g" name="roof_col_g"><label style="color:#0C3"> <strong>GREEN</strong></label>
     		<input value="r" <? if ($cond[1] == "r"){ echo 'checked="checked" ';}?>  onchange="change_color('r','9');" type="checkbox" style="background-color:#F30; width:25px" id="9_r" name="roof_col_r"><label style="color:#F00"> <strong>RED</strong></label>            
        </td>        
      </tr>
      <? } ?>
      
       <tr>
        <td colspan="2"  align="center"><BR>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
      </tr>
       <tr>
        <td  style="color:#0C0"><strong>GREEN</strong></td>
        <td   style="color:#F00"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>RED</strong></td>
      </tr>
       
         <? $j = 0;
		 foreach ($wind as $_wind) { $j++; ?>
       <tr>
        <td>
         <input  id="g_<? echo $j ?>" onchange="change_wind('g','<? echo $j ?>')"  type="checkbox" <? if (in_array($_wind["direction"],$g_wind)) { echo 'checked="checked"'; }?> value="<? echo $_wind["direction"] ?>"  name="g_<? echo $j ?>"> <? echo $_wind["description"]?> ( <? echo $_wind["direction"] ?>)
         </td>
         <td >
         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
          <input  id="r_<? echo $j ?>" onchange="change_wind('r','<? echo $j ?>')" type="checkbox" <? if (in_array($_wind["direction"],$r_wind)) { echo 'checked="checked"'; }?> value="<? echo $_wind["direction"] ?>"  name="r_<? echo $j ?>"> <? echo $_wind["description"]?> ( <? echo $_wind["direction"] ?>)
          </tr>
         <? } ?>
        
               
     
      
      <tr>
        <td >Stadium Phone Numbers</td>

        <td>
        	<input name="sid" type="hidden" id="sid" value="<? echo $stadium->vars["id"] ?>" />
			<input name="t_wind" type="hidden" id="sid" value="<? echo count($wind) ?>" />            
          	<textarea name="phone" id="phone"><? echo $stadium->vars["phone"] ?></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" ><input type="submit" value="Update" /></td>
      </tr>
    </table>
  </form>
</div>
<? if($_GET["in"]){ ?><script type="text/javascript">alert("Data has been Updated");
parent.location.reload(); 
window.parent.Shadowbox.close(); 
</script><? } ?>
</body>
</html>