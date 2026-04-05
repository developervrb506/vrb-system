<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("all_schedules")){ ?>
<?
$sal = get_clerk_week_salary($_POST["clerk"],$_POST["week"]);

if(is_null($sal)){
	$sal = new _salary();
	$insert = true;
}
$sal->vars["clerk"] = $_POST["clerk"];
$sal->vars["week"] = $_POST["week"];
$sal->vars["salary"] = $_POST["salary"];
$sal->vars["type"] = $_POST["type"];
$sal->vars["caja"] = $_POST["caja"];
$sal->vars["deductions"] = $_POST["deductions"];
$sal->vars["increases"] = $_POST["increases"];
$sal->vars["notes"] = $_POST["notes"];
if($insert){
	$sal->insert();	
}else{
	$sal->update();
}


header("Location: http://localhost:8080/ck/schedules.php?".$_POST["group"]."&realdate=".$_POST["week"]);
?>
<? }else{echo "Access Denied";} ?>