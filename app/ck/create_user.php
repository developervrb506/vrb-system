<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>

<?
$image = "";
if(isset($_GET["uid"])){
	$update = true;
	$user = get_clerk($_GET["uid"]);
	

	
	
	if ($_GET["dup"]) {
	$title = "Edit Duplicate User" ;
	}
	else{
	$title = "Edit " . $user->vars["name"];
	}

	if($user->admin()){
	    if($current_clerk->vars["id"] != $user->vars["id"] && !$current_clerk->vars["super_admin"]){
			header("Location: clerks.php?e=5");
		}
	}
}else{
	$update = false;
	$title = "Create New User";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Create New User</title>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.3.min.js"> </script>
<script type="text/javascript" src="../process/js/functions.js"></script>
 <script>
    jQuery.noConflict(); // prevent conflicts with prototype
  </script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"email",type:"null", msg:"Email is required"});
validations.push({id:"password",type:"null", msg:"Password is required"});
</script>

<script type="text/javascript">
var validations2 = new Array();
validations2.push({id:"login",type:"numeric", msg:"Login is a Number"});
validations2.push({id:"comment",type:"null", msg:"Please Select a Description"});
</script>

<script type="text/javascript">
var validations3 = new Array();
validations3.push({id:"aff_code",type:"null", msg:"Please add a code"});
</script>

<script type="text/javascript">
//Shadowbox.init();
function delete_login(id,clerk){
	if(confirm("Are you sure you want to DELETE this Login ?")){
		//document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/delete_phone_login.php?id="+id;
	    //document.getElementById("tr_"+id).style.display = "none";
	  document.location = "http://localhost:8080/ck/process/actions/delete_phone_login.php?id="+id+"&clerk="+clerk;	
	}
}


function delete_aff(id,clerk){
	if(confirm("Are you sure you want to DELETE this AFF Code ?")){
		//document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/delete_phone_login.php?id="+id;
	    //document.getElementById("tr_"+id).style.display = "none";
	  document.location = "http://localhost:8080/ck/process/actions/delete_agent_affiliate_code.php?id="+id+"&clerk="+clerk;	
	}
}

</script>

<script type="text/javascript">
function show_btn(){
	document.getElementById("btn").style.display = "block";
}

function check_image(){
	
var name = document.getElementById("image").value;
var ext = '.jpg';  

var image_url = "http://localhost:8080/images/profile_images/"+name+ext;	
	
$.get(image_url)
    .done(function() { 
        show_btn();

    }).fail(function() { 
        alert('Please upload First the image before mark the check');

    })
}

</script>


</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:200px; float:right">
<br /><span class="page_title">Profile Image</span><br /><br />
<form method="post" action="process/actions/create_user_action.php" onsubmit="return validate(validations)">
<? $name = $user->vars["id"]."_profile"; ?>
 <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $user->vars["id"] ?>" /><? } ?>
<p><strong>Step #1</strong> : Rename the Image with the following name : <input style="width:80px" name="image" id="image" type="text" readonly="readonly" value="<? echo $name ?>"></p>
<p><strong>Step #2</strong> : Upload through FTP :<input onchange="check_image();" style="width: 15px;height: 15px; position: absolute; margin-top: -1px;" type="checkbox"><BR>( Check when the image was already Uploaded)</p><BR><BR>
<? 	if ($user->vars["image"] != "no_image") { ?>

<img style="width: 150px; height: 150px; margin-left: 30px;" src="../images/profile_images/<? echo $user->vars["image"] ?>">
<? } ?>
<BR>

 <input id="btn" style="width: 120px; display:none;  margin-left: 30px;" type="submit" value="Save" />
</form>

</div>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_user_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $user->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $user->vars["name"] ?>" /></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input name="email" type="text" id="email" value="<? echo $user->vars["email"] ?>" /></td>
      </tr>
      <? if(!$update) { ?>
      <tr>
        <td>Password</td>
        <td><input name="password" type="text" id="password" value="<? //echo $user->vars["password"] ?>" /></td>
      </tr>
      <? } ?>
      <tr>
        <td>User Group</td>
        <td><? $s_group = $user->vars["user_group"]->vars["id"]; include "includes/group_list.php" ?></td>
      </tr>
      <tr>
        <td>Type</td>
        
        <td>
        	<table width="180" border="0" cellspacing="0" cellpadding="5">
        	<?
			$levels = get_all_ck_levels();
			foreach($levels as $level){				
				?>
				
                  <tr>
                    <td><? echo $level->vars["name"] ?></td>
                    <td><input name="type" id="type" <?
					 	if($user->vars["level"]->vars["id"] == $level->vars["id"] || !$update){echo 'checked="checked"';} 
					 ?> type="radio" value="<? echo $level->vars["id"] ?>" /></td>
                  </tr>
                
				<?
			}
			?>
            </table>
        </td>
      </tr>   
      <!--<tr>
        <td>AF Number</td>
        <td><input name="af" type="text" id="af" value="<? echo $user->vars["af"] ?>" /></td>
      </tr>  -->
      <tr>
        <td>Affiliate List</td>
        <td><? create_objects_list("list", "list", get_all_names_list(), "id", "name", "--None--", $user->vars["list"]) ?></td>
      </tr>
       <tr>
        <td>Extension:</td>
        <td><input name="extension" type="text" id="extension" value="<? echo $user->vars["ext"] ?>" /></td>
      </tr>
      
      <tr>
        <td>Has Schedule</td>
        <td>
        	<select name="schedule" id="schedule">
            	<option value="0">No</option>
                <option value="1" <? if($user ->vars["use_schedule"]){echo 'selected="selected"';} ?> >Yes</option>
                 
            </select>
        </td>
      </tr>
         
      
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
	</form>
</div>

<? 

if ($user->vars["user_group"]->vars["id"]== 15) { // 15 is the id for Agent Group
?>

        <br /><span class="page_title">Affiliate Codes</span><br /><br />
        
        <div class="form_box" style="width:650px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
         <tr>  
                <?  if ($update){
                  $agent_codes = get_all_affiliates_by_clerk($user->vars["id"]);
                  $str_aff =" ";
                   foreach ($agent_codes as $agent_code){
                      $str_aff .=  $agent_code->vars["aff"].", ";
                    }
                   $str_aff = substr($str_aff,0,-2);	
                ?>
                
                <td> <p  <? if (count($agent_codes)>0){ echo 'style="display:block"'; } else {echo 'style="display:none"'; }?> ><? echo $str_aff ?></p>
                  <a href="javascript:display_div('div_aff_add')" class="normal_link" title="Click Delete" > Add</a> |
                   <a href="javascript:display_div('div_aff_edit')" class="normal_link" title="Click Delete" > Edit</a> 
                <div id="div_aff_edit" style="display:none">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                       <td class="table_header" align="center">Aff Code</td>
                       <td class="table_header" align="center">Edit</td>
                       </tr>
                   
                   <?  foreach ($agent_codes as $agent_code){ if($i % 2){$style = "1";}else{$style = "2";}$i++; ?>
                      <tr>
                       <td class="table_td<? echo $style ?>" align="center"> <? echo $agent_code->vars["aff"]; ?></td>
                       <td class="table_td<? echo $style ?>" align="center"><a class="normal_link" href="javascript:;" onclick="delete_aff('<? echo $agent_code->vars["id"] ?>','<? echo $user->vars["id"] ?>');">
                    Delete
                </a></td>
                   
                      </tr> 
                   <? } ?>
                   </table>
                  
                 </div>
                 <div id="div_aff_add" <? if (count($agent_codes)>0){ echo 'style="display:none"'; }?>>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                       <td class="table_header" align="center">AFF CODE</td>
                       <td class="table_header" align="center">Edit</td>
                       </tr>
                       <form method="post" action="process/actions/create_agent_affiliate_code_action.php" onsubmit="return validate(validations3)">
                       <tr>
                       <input name="clerk" type="hidden" id="clerk" value="<? echo $user->vars["id"] ?>" />
                       <td class="table_td<? echo $style ?>" align="center"><input name="aff_code" type="text" id="aff_code" value="" /></td>
                       <td class="table_td<? echo $style ?>" align="center"><input name="sent" type="submit" id="sent" value="Add" /></td>
                   
                      </tr> 
                   </form>
                   </table>
                  
                 </div>
                 <? } ?>
              
              </tr>
         </table>     

</div>

<? } ?>




<br /><span class="page_title">Phone Login</span><br /><br />

<div class="form_box" style="width:650px;">
<table width="100%" border="0" cellspacing="0" cellpadding="10">
 <tr>  
        <?  if ($update){
		  $user_logins = get_all_clerk_phone_logins($user->vars["id"]);
		  $str_logins =" ";
		   foreach ($user_logins as $user_login){
			  $str_logins .=  $user_login->vars["login"].", ";
			}
		   $str_logins = substr($str_logins,0,-2);	
		?>
        <td>Phone Login:</td>
        <td> <p  <? if (count($user_logins)>0){ echo 'style="display:block"'; } else {echo 'style="display:none"'; }?> ><? echo $str_logins ?></p>
          <a href="javascript:display_div('div_login_add')" class="normal_link" title="Click Delete" > Add</a> |
           <a href="javascript:display_div('div_login_edit')" class="normal_link" title="Click Delete" > Edit</a> 
        <div id="div_login_edit" style="display:none">
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
               <td class="table_header" align="center">Login</td>
               <td class="table_header" align="center">Comment</td>
               <td class="table_header" align="center">Edit</td>
               </tr>
           
           <?  foreach ($user_logins as $user_login){ if($i % 2){$style = "1";}else{$style = "2";}$i++; ?>
              <tr>
               <td class="table_td<? echo $style ?>" align="center"> <? echo $user_login->vars["login"]; ?></td>
               <td class="table_td<? echo $style ?>" align="center"><? echo $user_login->vars["comment"]?></td>
               <td class="table_td<? echo $style ?>" align="center"><a class="normal_link" href="javascript:;" onclick="delete_login('<? echo $user_login->vars["id"] ?>','<? echo $user->vars["id"] ?>');">
        	Delete
        </a></td>
           
              </tr> 
           <? } ?>
           </table>
          
         </div>
         <div id="div_login_add" <? if (count($user_logins)>0){ echo 'style="display:none"'; }?>>
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
               <td class="table_header" align="center">Login</td>
               <td class="table_header" align="center">Description</td>
               <td class="table_header" align="center">Edit</td>
               </tr>
               <form method="post" action="process/actions/create_user_phone_login_action.php" onsubmit="return validate(validations2)">
               <tr>
               <input name="clerk" type="hidden" id="clerk" value="<? echo $user->vars["id"] ?>" />
               <td class="table_td<? echo $style ?>" align="center"><input name="login" type="text" id="login" value="" /></td>
               <td class="table_td<? echo $style ?>" align="center">
               <select id="comment" name="comment">
               <option value="" >- Select -</option>
               <option value="AF" >Affiliates</option>
               <option value="CS" >Costumer Service</option>
               <option value="CC" >Credit</option>
               <option value="Wagerin" >Wagerin</option>
               <option value="Payouts" >Payouts</option>
               <option value="SALES" >Sales</option>
               <option value="PPH" >PPH</option>
               </select>
               </td>
               <td class="table_td<? echo $style ?>" align="center"><input name="sent" type="submit" id="sent" value="Add" /></td>
           
              </tr> 
           </form>
           </table>
          
         </div>
         <? } ?>
      
      </tr>
 </table>     

</div>



</div>
<? include "../includes/footer.php" ?>
