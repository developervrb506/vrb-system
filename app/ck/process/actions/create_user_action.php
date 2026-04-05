<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
//print_r($_POST); exit;
if(isset($_POST["image"])){
 $user = get_clerk($_POST["update_id"]);
 $user->vars["image"] = clean_get("image").".jpg";
 $user->update(array("image"));
 header("Location: ../../create_user.php?uid=".$_POST["update_id"]);
}
/*$vars["af"] = clean_get("af");*/
else{
		
	if(isset($_POST["update_id"])){
      $user = get_clerk($_POST["update_id"]);    
	} else {
	   $user = new clerk();	
	}


	$user->vars["name"] = clean_get("name");
	$user->vars["email"] = clean_get("email");
	$user->vars["fake_email"] = clean_get("email");
	$user->vars["level"] = clean_get("type");
	$user->vars["user_group"] = clean_get("group_list");
	if(clean_get("list")){
	  $user->vars["list"] = clean_get("list");
	}
	if(clean_get("extension")){
	$user->vars["ext"] = clean_get("extension");
	}
	if(clean_get("phone_login")){
	$user->vars["phone_login"] = clean_get("ph_login");
	} 
   	$user->vars["use_schedule"] = clean_get("schedule");

    if(isset($_POST["update_id"])){
		if(!$user->vars["phone_login"]){ $user->vars["phone_login"] = 0;}
		if(!$user->vars["ext"]){ $user->vars["ext"] = 0;}

		
		$user->update();
		header("Location: ../../clerks.php?e=6");
	}else{
		$user->vars["af"] = '';
		$user->vars["password"] = super_encript(clean_get("password"));
		$user->insert();
		header("Location: ../../clerks.php?e=7");
	}
	

}

?>
