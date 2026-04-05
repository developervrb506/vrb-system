<? 
include(ROOT_PATH . "/ck/process/security.php");
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/


$pre =$_POST["pre"];
$stdata = get_all_stadium_formula_data();

for($i=1;$i<31;$i++){

  $stdata[$i]->vars[$pre."_minor_range"] = $_POST["minor_range_".$i];  
  $stdata[$i]->vars[$pre."_major_range"] = $_POST["major_range_".$i];    
  $stdata[$i]->vars[$pre."_minor"] = $_POST["minor_".$i];    
  $stdata[$i]->vars[$pre."_major"] = $_POST["major_".$i];      
  if($pre == "pk"){
  $stdata[$i]->vars[$pre."_diff"] = $stdata[$i]->vars[$pre."_major"] - $stdata[$i]->vars[$pre."_minor"];    
  }
  else{
  $stdata[$i]->vars[$pre."_diff"] = $stdata[$i]->vars[$pre."_minor"] - $stdata[$i]->vars[$pre."_major"];    	  
  }
  $stdata[$i]->update(array($pre."_minor_range",$pre."_major_range",$pre."_minor",$pre."_major",$pre."_diff"));
	
}




header("Location: ../../stadium_formula_data.php");


?>