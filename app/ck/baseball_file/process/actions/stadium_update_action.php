<? 
include(ROOT_PATH . "/ck/process/security.php");

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/


if($_POST["temp_col_g"] == "g"){ $temp_col = "g"; } else { $temp_col = "r";}
if($_POST["humidity_col_g"] == "g"){ $humidity_col = "g"; } else { $humidity_col = "r";}
if($_POST["wind_speed_col_g"] == "g"){ $wind_speed_col = "g"; } else { $wind_speed_col = "r";}
if($_POST["wind_gust_col_g"] == "g"){ $wind_gust_col = "g"; } else { $wind_gust_col = "r";}
if($_POST["air_pressure_col_g"] == "g"){ $air_pressure_col = "g"; } else { $air_pressure_col = "r";}
if($_POST["dew_point_col_g"] == "g"){ $dew_point_col = "g"; } else { $dew_point_col = "r";}
if($_POST["dry_air_col_g"] == "g"){ $dry_air_col = "g"; } else { $dry_air_col = "r";}
if($_POST["vapor_pressure_col_g"] == "g"){ $vapor_pressure_col = "g"; } else { $vapor_pressure_col = "r";}
if($_POST["moist_air_col_g"] == "g"){ $moist_air_col = "g"; } else { $moist_air_col = "r";}
if($_POST["aird_col_g"] == "g"){ $aird_col = "g"; } else { $aird_col = "r";}
if($_POST["roof_col_g"] == "g"){ $roof_col = "g"; } else { $roof_col = "r";}
if($_POST["time_col_g"] == "g"){ $time_col = "g"; } else { $time_col = "r";}



$w_green = $w_red = "";
for ($i=1;$i<=$_POST["t_wind"];$i++){

 if(isset($_POST["r_".$i])) {$w_red .= $_POST["r_".$i].",";}
 if(isset($_POST["g_".$i])) {$w_green .= $_POST["g_".$i].",";} 

	
}

$w_green = substr($w_green,0,-1);
$w_red = substr($w_red,0,-1);




$stadium = get_baseball_stadium($_POST["sid"]);
$roof = $_POST["roof_cond"];
if (!$stadium->vars["has_roof"]){ $roof = "-1";}

$stadium->vars["phone"] = $_POST["phone"];
$stadium->vars["humidity"] = $_POST["humidity"];
$stadium->vars["temp"] = $_POST["temp"];
$stadium->vars["wind_speed"]= $_POST["wind_speed"];
$stadium->vars["wind_gust"]= $_POST["wind_gust"];
$stadium->vars["air_pressure"]= $_POST["air_pressure"];
$stadium->vars["dew_point"]= $_POST["dew_point"];
$stadium->vars["dry_air"]= $_POST["dry_air"];
$stadium->vars["vapor_pressure"]= $_POST["vapor_pressure"];
$stadium->vars["moist_air"]= $_POST["moist_air"];
$stadium->vars["aird"]= $_POST["aird"];
$stadium->vars["roof"]= $roof;

$default = -1;

//time
//if($_POST["time"] == "0"){ $time_col = $default; }

//temp
if($_POST["temp_col_g"] == "" && $_POST["temp_col_r"] == ""){
 $stadium->vars["temp_cond"] = $default;
} else {
 $stadium->vars["temp_cond"] = $_POST["temp_cond"]."_".$temp_col;	
}
//humidity
if($_POST["humidity_col_g"] == "" && $_POST["humidity_col_r"] == ""){
 $stadium->vars["humidity_cond"] = $default;
} else {
 $stadium->vars["humidity_cond"] = $_POST["humidity_cond"]."_".$humidity_col;
}
//Wind speed
if($_POST["wind_speed_col_g"] == "" && $_POST["wind_speed_col_r"] == ""){
 $stadium->vars["wind_speed_cond"] = $default;
} else {
 $stadium->vars["wind_speed_cond"] = $_POST["wind_speed_cond"]."_".$wind_speed_col;	
}
//Wind gust
if($_POST["wind_gust_col_g"] == "" && $_POST["wind_gust_col_r"] == ""){
 $stadium->vars["wind_gust_cond"] = $default;
} else {
 $stadium->vars["wind_gust_cond"] = $_POST["wind_gust_cond"]."_".$wind_gust_col;
}
//Air pressure
if($_POST["air_pressure_col_g"] == "" && $_POST["air_pressure_col_r"] == ""){
 $stadium->vars["air_pressure_cond"] = $default;
} else {
 $stadium->vars["air_pressure_cond"] = $_POST["air_pressure_cond"]."_".$air_pressure_col;	
}
//Dew point
if($_POST["dew_point_col_g"] == "" && $_POST["dew_point_col_r"] == ""){
 $stadium->vars["dew_point_cond"] = $default;
} else {
 $stadium->vars["dew_point_cond"] = $_POST["dew_point_cond"]."_".$dew_point_col;
}
// Dry air
if($_POST["dry_air_col_g"] == "" && $_POST["dry_air_col_r"] == ""){
 $stadium->vars["dry_air_cond"] = $default;
} else {
 $stadium->vars["dry_air_cond"] = $_POST["dry_air_cond"]."_".$dry_air_col;
}
// Vapor Presure
if($_POST["vapor_pressure_col_g"] == "" && $_POST["vapor_pressure_col_r"] == ""){
 $stadium->vars["vapor_pressure_cond"] = $default;
} else {
 $stadium->vars["vapor_pressure_cond"] = $_POST["vapor_pressure_cond"]."_".$vapor_pressure_col;
}
// Moist Air
if($_POST["moist_air_col_g"] == "" && $_POST["moist_air_col_r"] == ""){
 $stadium->vars["moist_air_cond"] = $default;
} else {
 $stadium->vars["moist_air_cond"] = $_POST["moist_air_cond"]."_".$moist_air_col;
}

// Aird
if($_POST["aird_col_g"] == "" && $_POST["aird_col_r"] == ""){
 $stadium->vars["aird_cond"] = $default;
} else {
 $stadium->vars["aird_cond"] = $_POST["aird_cond"]."_".$aird_col;
}

// Roof
if($_POST["roof_col_g"] == "" && $_POST["roof_col_r"] == ""){
 $stadium->vars["roof_cond"] = $default;
} else {
 $stadium->vars["roof_cond"] = $_POST["roof_cond"]."_".$roof_col;
}
// Time
if($_POST["time_col_g"] == "" && $_POST["time_col_r"] == ""){
 $stadium->vars["time"] = $default;
} else {
 $stadium->vars["time"] = $_POST["time"]."_".$time_col;
}


$stadium->vars["wind_direction_green"]= $w_green;
$stadium->vars["wind_direction_red"]= $w_red;

/*
echo "<pre>";
print_r($stadium);
echo "</pre>";
*/

$stadium->update(array("phone","humidity","wind_speed","wind_gust","air_pressure","dew_point","dry_air","vapor_pressure","moist_air","aird","wind_direction_green","wind_direction_red","humidity_cond","wind_speed_cond","wind_gust_cond","air_pressure_cond","dew_point_cond","dry_air_cond","vapor_pressure_cond","moist_air_cond","aird_cond","temp","temp_cond","roof","roof_cond","time"));

header("Location: ../../stadium_phones.php?in=1&sid=".$stadium->vars["id"]);
?>