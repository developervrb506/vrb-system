<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("manage_permission")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function delete_permission(clerk,permission_id){
	if(confirm("Are you sure you want to Remove this Permission?")){
	  document.location = BASE_URL . "/ck/process/actions/delete_permission_user.php?clerk="+clerk+"&permission="+permission_id;
		
	}
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Permissions </title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Manage Permission</span>
<BR/><BR/>
<form method="post">
&nbsp;&nbsp;&nbsp;
Permission:
<?

  $permission = post_get("permission_list");


$data = array(
			array("id"=>"balance_adjustment","label"=>"Balance Adjustment"),
    		array("id"=>"balance_disbursements","label"=>"Balance Disbursements"),
			array("id"=>"balance_receipt","label"=>"Balance Receipts"),
    		array("id"=>"reverse_transactions","label"=>"Reverse Transactions")
		);
create_list("permission_list", "permission_list", $data, $permission);
?>


&nbsp;&nbsp;&nbsp;
<input name='search' type="submit" value="Search" />
</form>
<BR/><BR/>



<?
if (isset($_POST["permission_list"])){

$clerks_allowed = get_permissions_clerk($permission);

echo "</pre>";
?>
<br /><br />

<?  
  
  $str_clerk ="";
  foreach ($clerks_allowed as $allowed) {
   $str_clerk .= "'".$allowed->vars["user"]."'," ;
  }
  $str_clerk = substr($str_clerk,0,-1);
  
  $denied_clerk = get_all_clerks_exclude_list($str_clerk);
?>






<div class="form_box" style="width:100%;">

  <div align="center" class="form_box" style="width:49%;">
    <form action="process/actions/add_permission_user.php" method="post" >
    <input name="permission" type="hidden" id="permission" value="<? echo $clerks_allowed[0]->vars["id"] ?>" />
     <input name="permission_name" type="hidden" id="permission_name" value="<? echo $permission ?>" />
    <strong>User</strong> : &nbsp;&nbsp;
    <? create_objects_list("clerk", "clerk", $denied_clerk, "id", "name", $default_name = "","","","_clerk");  
    ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="search" type="submit" value="Add" />
    </form>
     </div>


<spam><strong>User with Access </strong></spam>
<table width="50%" border="0" cellspacing="0" cellpadding="0">

  <tr>
  	<td class="table_header" align="center">User</td>
    <td class="table_header" align="center">Remove</td>
  </tr>
<? 
  $str_clerk ="";
  foreach ($clerks_allowed as $clerk_allowed) {
	if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  $clerk = get_clerk($clerk_allowed->vars["user"]);	
    ?>  
    
    <tr id="tr_<? echo $clerk_allowed->vars["user"]; ?>" >
    <td class="table_td<? echo $style ?>" align="center"><?  echo $clerk->vars["name"]; ?>  </td>
    <td class="table_td<? echo $style ?>" align="center">
    <a class="normal_link" href="javascript:;" onclick="delete_permission('<? echo $clerk_allowed->vars["user"] ?>','<? echo $clerks_allowed[0]->vars["id"] ?>');">
        	Remove
        </a>
    </td>
    </tr>
   
<?
 // $str_clerk .= "'".$clerk_allowed->vars["user"]."'," ;
  }
 // $str_clerk = substr($str_clerk,0,-1);
  ?>
   
 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

<table>
<BR/><BR/>



 </div>
</div>

<? } ?>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
