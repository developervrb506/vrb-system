<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?

$user = $_POST["user"];
$permission_group = get_all_permissions_by_clerk($user);
unset($_POST["user"]);
unset($_POST["send"]);
$selected_permissions = $_POST;


if (count($permission_group)>0){
	foreach ($permission_group as $permission){
      $permissions[$permission["permission"]] = $permission["permission"];
	}
}
else {
	   $permissions = $selected_permissions; 
	 }	

$remove_permissions = array_diff($permissions,$selected_permissions);



if (count($permission_group)> 0) {
	$add_permissions = array_diff($selected_permissions,$permissions);
} else {$add_permissions = $selected_permissions;  }


//Delete Permissions
if (count($remove_permissions) > 0){
  $str_delete = "";
  foreach ($remove_permissions as $delete){	
	$str_delete .= "'".$delete."',";
  }
  $str_delete = substr($str_delete,0,-1);
 
  delete_permission_clerk_by_list($user,$str_delete);
}

//Add new permissions
if (count($add_permissions) > 0){
  foreach ($add_permissions as $add){
     insert_permission_clerk($add,$user);
   }
}



header("Location: ../../permissions_user.php?user=$user");

?>