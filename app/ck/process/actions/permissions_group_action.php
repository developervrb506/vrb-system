<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?

$group = $_POST["group"];
$permission_group = get_permissions_group($group);
unset($_POST["group"]);
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
 
  delete_permission_group_by_list($group,$str_delete);
}

//Add new permissions
if (count($add_permissions) > 0){
  foreach ($add_permissions as $add){
     insert_permission_group($add,$group);
   }
}



header("Location: ../../permissions_group.php?group=$group");

?>