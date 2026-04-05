<? 
include(ROOT_PATH . "/ck/process/security.php");

//print_r($_POST);
$column = get_baseball_column_description($_POST["column"]);



if(!is_null($column)){
	$column->vars["description"] = $_POST["description"];
	$column->update(array("description")); 
     

}

if(isset($_POST["column2"])){

 $column = get_baseball_column_description($_POST["column2"]);

if(!is_null($column)){
	$column->vars["description"] = $_POST["weig_avg"];
	$column->update(array("description")); 
     

 }
	
	
	
}

header("Location: ../../report.php");  
?>