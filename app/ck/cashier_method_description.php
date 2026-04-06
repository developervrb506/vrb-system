<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_access")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Cashier Method Description</title>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>

<div class="page_content" style="padding-left:10px;">
<?
if(isset($_POST["update_id"])){
			
		$method_description = get_cashier_method_description($_POST["update_id"]);
		$method_description->vars["display"] = str_replace("'","\'",$_POST["display"]);
		$method_description->vars["description"] = str_replace("'","\'",$_POST["description"]);
		$method_description->vars["order"] = str_replace("'","\'",$_POST["order"]);
		$method_description->vars["type"] = str_replace("'","\'",$_POST["type"]);
		$method_description->vars["steps"] = str_replace("'","\'",$_POST["steps"]);
     	$method_description->vars["fees"] = str_replace("'","\'",$_POST["fees"]);
		$method_description->vars["extra_info"] = str_replace("'","\'",$_POST["extra_info"]);
		$method_description->vars["mobile"] = str_replace("'","\'",$_POST["mobile"]);
		$method_description->vars["real_fees"] = $_POST["real_fees"];	
		$method_description->vars["thanks_message"] = str_replace("'","\'",$_POST["thanks_message"]);	
		$method_description->vars["internal"] = str_replace("'","\'",$_POST["internal"]);	
		$method_description->vars["internal_extra"] = str_replace("'","\'",$_POST["internal_extra"]);	
		$method_description->update();
		//header("Location:cashier_method_description.php?e=72");		
	
	echo "<pre>";
//print_r($_POST);
echo "</pre>";
	
	
	
}
?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<?

if(isset($_GET["mid"])){
	//details
	
	   $method_description = get_cashier_method_description($_GET["mid"]);
	   $title = "Edit ".$method_description->vars['cashier_method']->vars['name'];
	   $hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$method_description->vars["id"] .'" />';
	   $edit = true;
	
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	
    <script type="text/javascript">
    var validations = new Array();
    validations.push({id:"title",type:"null", msg:"Please insert the Subject"});
	validations.push({id:"description",type:"null", msg:"Please insert the Issue"});
	validations.push({id:"solution",type:"null", msg:"Please insert the Solution"});
    validations.push({id:"status",type:"null", msg:"Please Select the Status"});
    </script>
   
	<div class="form_box" style="width:900px;">
          
        <form method="post" action="cashier_method_description.php" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
        &nbsp;&nbsp;
         
          <tr>
            <td>Display Name</td>
            <td><input width="250px" name="display" type="text" value="<? echo $method_description->vars["display"]?>"/></td>
          </tr> 
          <tr>
          
          <tr>
            <td>Order Name</td>
            <td><input width="250px" name="order" type="text" value="<? echo $method_description->vars["order"]?>"/></td>
          </tr> 
          <tr>
            <td>Type</td>
            <td><input width="25px" name="type" type="text" value="<? echo $method_description->vars["type"]?>"/></td>
          </tr> 
          
          <tr>
            <td>Description</td>
           <td><textarea name="description" cols="100" rows="20"><? echo $method_description->vars["description"]?></textarea></td>
          </tr> 
          <tr>
            <td>Steps</td>
            <td><textarea name="steps" cols="100" rows="20"><? echo $method_description->vars["steps"]?></textarea></td>
          </tr> 
           <tr>
            <td>Fees</td>
           <td><textarea name="fees" cols="100" rows="10"><? echo $method_description->vars["fees"]?></textarea></td>
          </tr> 
  
          <tr>
            <td>Extra</td>
             <td><textarea name="extra_info" cols="100" rows="20"><? echo $method_description->vars["extra_info"]?></textarea></td>
           </tr>
          <tr>  
          <tr>
            <td>Mobile</td>
             <td><textarea name="mobile" cols="100" rows="20"><? echo $method_description->vars["mobile"]?></textarea></td>
           </tr>
           
          <tr>
            <td>Real Fees</td>
             <td><input width="200px"name="real_fees" type="text" value="<? echo $method_description->vars["real_fees"]?>"/></td>
           </tr>
           <tr>
            <td>Thanks Message</td>
             <td><textarea name="thanks_message" cols="100" rows="20"><? echo $method_description->vars["thanks_message"]?></textarea></td>
            <tr>
            <td>Internal Info</td>
             <td><textarea name="internal" cols="100" rows="20"><? echo $method_description->vars["internal"]?></textarea></td>
           </tr>
             </tr>
            <tr>
            <td>Internal Extra</td>
             <td><textarea name="internal_extra" cols="100" rows="20"><? echo $method_description->vars["internal_extra"]?></textarea></td>
           </tr>
             </tr>
          <tr>      
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
 ?>


<span class="page_title">Cashier Method Description</span>
<br />

<? $methods = get_all_cashier_methods_description(); ?>
<?


 include "includes/print_error.php" ?>

<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="updater"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header"><strong>Order</strong></td>
    <td class="table_header"><strong>Method</strong></td>
    <td class="table_header"><strong>Type</strong></td>
    <td class="table_header"><strong>Display</strong></td>
    <td class="table_header" align="center"><strong>Description</strong></td>
    <td class="table_header" align="center"><strong>Steps</strong></td>    
    <td class="table_header" align="center"><strong>Fees</strong></td>
    <td class="table_header" align="center"><strong>Extra</strong></td>
    <td class="table_header" align="center"><strong>Mobile</strong></td>      
    <td class="table_header" align="center"><strong>Real_fees</strong></td>
    <td class="table_header" align="center"><strong>Thanks Message</strong></td> 
    <td class="table_header" align="center"><strong>Internal</strong></td> 
    <td class="table_header" align="center"><strong>Internal Extra</strong></td>          
    <td class="table_header" align="center"><strong></strong></td>    
    <td class="table_header" align="center"><strong></strong></td>
  </tr>
  <?
   $i=0; 
   foreach($methods as $mt){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>  
  <tr>
    <td class="table_td<? echo $style ?>"><? echo $mt->vars["order"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $mt->vars["cashier_method"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo $mt->vars["type"]; ?></td>
     <td class="table_td<? echo $style ?>"><? echo $mt->vars["display"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["description"],30) ?>  </td>
    <td class="table_td<? echo $style ?>" align=""><? echo text_preview($mt->vars["steps"],30) ?>  </td>
    <td class="table_td<? echo $style ?>" align=""><? echo text_preview($mt->vars["fees"],30) ?>  </td>    
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["extra_info"],30) ?>  </td>  
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["mobile"],30) ?>  </td>        
    <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["real_fees"] ?>  </td> 
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["thanks_message"],50) ?>  </td>    
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["internal"],50) ?>  </td>  
    <td class="table_td<? echo $style ?>" align="center"><? echo text_preview($mt->vars["internal_extra"],50) ?>  </td>         
    <td class="table_td<? echo $style ?>" align="center"><a href="view_cashier_method_desc.php?mid=<? echo $mt->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=500;width=600">View</a></td>      
    <td class="table_td<? echo $style ?>" align="center"><a href="cashier_method_description.php?mid=<? echo $mt->vars["id"]; ?>" class="normal_link">Edit </a></td>
  </tr>
  <? } ?>
   <tr>
    <td class="table_last" colspan="100" align="center"></td>
  </tr>

</table>
<? } ?>
<script type="text/javascript">
function change_method_type(mname, mid, old_type, new_type){
	if(confirm("Are you sure you want to change the way access is managed for "+mname+"?")){
		location.href = "process/actions/change_cashier_method_type.php?mid="+mid+"&type="+new_type;
	}else{
		document.getElementById("type_"+mid).value = old_type;
	}
}
</script>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>