<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
if(isset($_GET["uid"])){
	$user = get_clerk($_GET["uid"]);

//Default Values for New User
//insert the duplicate user
  //$duplicate_user = new clerk($vars);
  $duplicate_user = new clerk();
  //$duplicate_user->vars["id"] = "";
  $duplicate_user->vars["name"] = "";
  $duplicate_user->vars["email"] = "";
  $duplicate_user->vars["fake_email"] = "";
  $duplicate_user->vars["ext"] = 0;
  $duplicate_user->vars["list"] = $user->vars["list"];
  $duplicate_user->vars["af"] = $user->vars["af"];
  $duplicate_user->vars["password"] = super_encript("123456789");
  $duplicate_user->vars["available"] = $user->vars["available"];
  $duplicate_user->vars["super_admin"] = $user->vars["super_admin"];
  $duplicate_user->vars["level"] = $user->vars["level"]->vars["id"];
  $duplicate_user->vars["user_group"] = $user->vars["user_group"]->vars["id"];
  $duplicate_user->vars["phone_login"] = 0;

  
  $duplicate_user->insert();
//Add the persmission for the new user
for ($i=0;($i<(count($user->permissions)));$i++)
{
$permision["user"] =$duplicate_user->vars["id"];
$permision["permission"] = $user->permissions[$i]->vars["id"];
$duplicate_permissions = new clerk($permision);
$duplicate_permissions->insert_permission();
}
header("Location: ../../create_user.php?uid=".$duplicate_user->vars['id']."&dup=1");
}
else
header("Location: ../../clerks.php");
?>