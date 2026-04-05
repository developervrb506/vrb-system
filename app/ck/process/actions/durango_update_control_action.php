<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	color: #000;
}
body {
	background-color: #FFF;
}
-->
</style>
<?
// 


$months = $_POST["months"];
$period = $_POST["period"];
$priority = get_durango_priority($period);
$next_priority = ($priority["priority"])+ 1;
$control = get_durango_control($_POST["id"]);
$type = $_POST["type"];       


//Date Operations for period
/*
This can be activated but the following changes had to be done
- Check if the $_POST["months"] contains the rigth value
- Control table will be keep the expired date
- $vars["date"] = $date
- Record Table will be keep the Actual date
  $vars2["date_used"] = date("Y-m-d");
- Change the sp called sp_durango 
  Replace (AND months <= ( FLOOR(DATEDIFF(DATE(CURDATE()),c.date)/30)))
  by (AND c.date >= DATE(CURDATE())

/*
$months = str_replace("Months","",$months])	 ;
if (contains_ck($months,"Another")){
$months = str_replace("Another","",$months]) ;
$date = date("Y-m-d"),strtotime(date("Y-m-d") + $months months); // This line has to add the months to the actual date
}
*/


//Update the Type Field
$vars1["id"] = $_POST["id"];
$vars1["type"] = $type;
$durango_name = new durango($vars1);
$durango_name ->update_name(array("type"));


// Array for update Control
$vars["id"]= $control["id"];
$vars["name"] = $_POST["id"];
$vars["period"] = $period;
$vars["priority"] = $next_priority;
$vars["date"]= date("Y-m-d");
 
$durango_control = new durango($vars);
$durango_control->update();

	
//Array for Table durango_control
$vars2["client"] = $control["name"];
$vars2["date_used"] = $control["date"];

$durango_record = new durango($vars2);
$durango_record->insert("durango_record");


if($type == "skincare"){
	$econtent = "Skincare Name<br /><br />";
	$econtent .= "First Name: ".$_POST["firstname"];
	$econtent .= "<br />Last Name: ".$_POST["lastname"];
	$econtent .= "<br />Address: ".$_POST["address"];
	$econtent .= "<br />City: ".$_POST["city"];
	$econtent .= "<br />State: ".$_POST["state"];
	$econtent .= "<br />Zip: ".$_POST["zip"];
	$econtent .= "<br />Credit Card #: ".$_POST["ccn"];
	$econtent .= "<br />CVV: ".$_POST["cvv"];
	$econtent .= "<br />Amount: ".$_POST["amount"];
	$email = get_list_email($_POST["email"]);
	send_email_ck($email->vars["email"], "Skincare Name", $econtent, true);
}




echo "<body align ='center'>";
echo "<br />";
echo "<br />";
echo "<br />";
echo "<p align  ='center'><strong>        Name has been archived. </strong>";
echo "</body>";
?>
