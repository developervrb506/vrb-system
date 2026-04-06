<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets_categories")){ ?>
<?


$groups = get_all_user_groups_chatids();
$live_help_departments = get_live_help_departments();
$live_help_depts = array();
foreach ($live_help_departments as $lhdep) {    
  $live_help_depts[] = $lhdep->vars["deptID"].'//'.$lhdep->vars["name"];
}

if (isset($_POST['process'])){
	$categorie = get_ticket_categorie($_POST['process']);
			
	$categorie->vars["instructions"] = clean_str_ck($_POST['instructions']);
	$categorie->vars["notes"] = clean_str_ck($_POST['notes']);
	
	if($categorie->vars["dep_id_live_chat"] != $_POST['department'] ) {
	  //echo "CHANGE";
	  get_tickets_to_update_department($categorie->vars["id"],$_POST['department']);	
	}
	
	$categorie->vars["dep_id_live_chat"] = $_POST['department'];
	$categorie->update(array("instructions","notes","dep_id_live_chat"));
	
	
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tickets Categories</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	
  /*window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
*/

  
function conf_delete(name, id){
   
  if(confirm("Are you sure you want to DELETE "+name+" Category and ALL its Tickets from the system? ")){
   // console.log(BASE_URL . "/ck/process/actions/delete_tickets_category.php?delete="+id);
    document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_tickets_category.php?delete="+id;
    document.getElementById("tr_"+id).style.display = "none";
    alert('Tickets Deleted !!');

  }
}


</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
  <div align="right">
  <iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<br /><br />
<? include "includes/print_error.php" ?>    
<?



if(isset($_GET["detail"])){
	//details
	$categorie = get_ticket_categorie($_GET["idf"]);
	 $tgroup = $groups[$categorie->vars["dep_id_live_chat"]];

	
	
	?>
    <span class="page_title">Edit Categorie</span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"affiliate",type:"null", msg:"Name is required"});
	validations.push({id:"description",type:"null", msg:"Comment is required"});
    </script>
    <div align="right">
     <span ><a href="<?= BASE_URL ?>/ck/tickets_categories.php">Back</a></span>
    </div>
	<div class="form_box" style="width:500px;">
        <form method="post" action="?e=52" onsubmit="return validate(validations)" enctype="multipart/form-data">
        <input name="process" type="hidden" id="process" value="<? echo $categorie->vars["id"] ?>" />
		
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Subject</td>
            <td><input name="subject" type="text" id="subject" value="<? echo $categorie->vars["description"] ?>" readonly="readonly" /></td>
          </tr> 
          <tr>
            <td>Department</td>
            
            <td>
            <select  name="department" id="department<? echo $tk->vars["id"] ?>">        
	             <option value="<? $categorie->vars["dep_id_live_chat"] ?>" id=""  ><? echo $tgroup->vars["name"] ?></option>
                <? 
				foreach ($live_help_depts as $lhsdep) {
				  $lhsdep   = explode("//",$lhsdep);
				  $deptid   = $lhsdep[0];
				  $deptname = $lhsdep[1];
				  $tgroup_dep = $groups[$deptid];	
				?>
                   <? // if ($deptid <> $tk->vars["dep_id_live_chat"]) { ?>
                   <option value="<? echo $deptid; ?>"><? echo $tgroup_dep->vars["name"] ?></option>
                   <? // } ?>
                <? } ?>      
              </select>
            </td>
            
          </tr> 
          <tr>
            <td>Instructions</td>
            <td>
             <textarea cols="45" rows="15" name="instructions" id="intructions" ><? echo $categorie->vars["instructions"] ?></textarea>          
           </td>
          </tr> 
          <tr>
            <td>Note</td>
            
            <td>
            <textarea cols="45" rows="15" name="notes" id="notes" ><? echo $categorie->vars["notes"] ?></textarea>  
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
	//end details
}else{
	?>
<span class="page_title">Tickets Categories</span><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Subject</td>
   <td class="table_header" align="center">Department</td>  
    <td class="table_header" align="center">Instructions</td>
    <td class="table_header" align="center">Notes</td>
  
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
   $categories = get_all_ticket_categories(0);
   foreach( $categories as $category){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $tgroup = $groups[$category->vars["dep_id_live_chat"]];
  ?>
  <tr id="tr_<? echo $category->vars["id"] ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $category->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $category->vars["description"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tgroup->vars["name"]; ?></td>        
    <td class="table_td<? echo $style ?>" align="center"><? echo $category->vars["instructions"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $category->vars["notes"]; ?></td>

    <td class="table_td<? echo $style ?>" align="center">  <a href="?detail&idf=<? echo $category->vars["id"]; ?>" class="normal_link">Edit</a></td>  
     <td class="table_td<? echo $style ?>" align="center">  <a href="" onclick="conf_delete('<? echo $category->vars["description"]?>','<? echo $category->vars["id"]?>');" class="normal_link">Delete</a></td>     
    
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
   
  </tr>

</table>


<? } ?>
</div>



<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>