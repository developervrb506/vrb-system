<?
require_once(ROOT_PATH . '/ck/db/handler.php');

$sql = "SELECT * FROM `name` WHERE list = 6 AND clerk IN (5,8) AND status = 10 LIMIT 0,400";
$names = get($sql, "ck_name");
$i = 0;

foreach($names as $name){
	$sql = "SELECT COUNT(*) as number FROM  vrbmarke_clerks.call WHERE name = '".$name->vars["id"]."'";
	$count = get_str($sql,true);
	
	if($count["number"]<=4){
		$name->vars["available"] = "1";
		$name->vars["status"] = "1";
		$name->vars["clerk"] = "0";	
		$name->vars["lead"] = "0";	
		$name->vars["closer_attended"] = "0";	
		$name->vars["next_date"] = "0000-00-00 00:00:00";
		echo "new : ";
		$name->update();
	}
	
	/*if($name->vars["note"] != "" || $name->vars["status"]->vars["id"] == 9){
		$name->vars["lead"] = "1";
		echo "lead : ";
		$name->update();	
	}else if($name->vars["status"]->vars["id"] == 6){
		$name->vars["status"] = "1";
		$name->vars["clerk"] = "0";	
		$name->vars["next_date"] = "0000-00-00 00:00:00";
		echo "new : ";
		$name->update();	
	}else{
		$sql = "SELECT COUNT(*) as number FROM  vrbmarke_clerks.call WHERE name = '".$name->vars["id"]."'";
		$count = get_str($sql,true);
		
		if($count["number"]>2){
			$name->vars["status"] = "10";
			$name->vars["available"] = "0";
			echo "limbo : ";
			$name->update();	
		}else{
			$name->vars["status"] = "1";
			$name->vars["clerk"] = "0";	
			$name->vars["next_date"] = "0000-00-00 00:00:00";
			echo "new : ";
			$name->update();	
		}	
	}*/
	
	
	/*$name->vars["lead"] = "1";
	$name->update();*/
	
	
	
	/*if($name->vars["note"] == ""){
		$name->vars["status"] = "1";
		$name->vars["clerk"] = "0";	
		$name->vars["next_date"] = "0000-00-00 00:00:00";
		echo "new : ";
		$name->update();	
	}else{
		$name->vars["lead"] = "1";
		$i++;
		if($i > 30){
			$name->update();
		}
	}*/
	
	
	/*$sql = "SELECT COUNT(*) as number FROM  vrbmarke_clerks.call WHERE name = '".$name->vars["id"]."'";
	$count = get_str($sql,true);
	
	if($count["number"]>2){
		$name->vars["status"] = "10";
		$name->vars["available"] = "0";
		$name->update();	
	}else{
		$name->vars["status"] = "1";
		$name->vars["clerk"] = "0";	
		$name->vars["next_date"] = "0000-00-00 00:00:00";
		$name->update();	
	}*/
	
	
	echo $name->vars["id"];
	echo "<br>";
}



?>
