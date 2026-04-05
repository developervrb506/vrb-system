<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners Testimonial </title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">

<? if($_GET["a"] == "a"){ ?>
alert("Record Added");
<? } ?>
<? if($_GET["a"] == "d"){ ?>
alert("Record Deleted");
<? } ?>
<? if($_GET["a"] == "u"){ ?>
alert("Record Updated");
<? } ?>
<!--
function delete_testimonial(ID) {
	var answer = confirm("Are you sure that you want to delete this testimonial?");
	if (answer){		
	   window.location = "process/actions/partners_testimonials_action.php?id="+ID;
	}	
}
//-->
function change_page(value){
	document.location.href = "" + value;
}

</script>
<script type="text/javascript">
  validations = new Array();
  validations.push({id:"description",type:"null", msg:"Please provide a testimonial"});  
  validations.push({id:"person_name",type:"null", msg:"Please provide the person's name who gave the testimonial"});	  	   
</script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">


<?

$testimonial_id = $_GET["edit_id"];
$title_form = "Add a Partner Testimonial";
?>
<!-- Contenido -->
<? if(!isset($testimonial_id)){ ?>
<span class="page_title">Partners Testimonial </span>
<br><br>
  <table style="cursor:pointer;" class="sortable">
    <thead>
        <tr>
            <th class="table_header" scope="col" style="text-align: center">Testimonial</th>
            <th class="table_header" scope="col" style="text-align: center">Person who gave the testimonial</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Edit</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Delete</th>            
        </tr>
    </thead>
    <tbody id="the-list">
    <?
	$testimonials = get_all_testimonials_affiliate();
	foreach($testimonials as $testimonial){
	 if($i % 2){$style = "1";}else{$style = "2";} $i++;
	?>
        <tr>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $testimonial->vars["description"]; ?></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><? echo $testimonial->vars["person_name"]; ?></th>         
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="change_page('partners_testimonials.php?edit_id=<? echo $testimonial->vars["id"] ?>')" type="button" name="Button" value="View" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="delete_testimonial('<? echo $testimonial->vars["id"] ?>')" type="button" name="Button" value="Delete" /></th> 
        </tr>  
    <? } ?>  
           <tr>
			  <th class="table_last" colspan="100"></th>
			</tr>
    </tbody>
    </table>
    
<? }else{$title_form = "Edit Partner Testimonial";} ?>
	<? 
	$testimonial = get_testimonials_affiliate($testimonial_id); 
	?>   
    <br /><span class="page_title"><? echo $title_form ?> </span><br />
    <form action="./process/actions/partners_testimonials_action.php" method="post" onSubmit="return validate(validations);">
	<table width="900" border="0" cellspacing="0" cellpadding="0" style="padding:10px;">      
      <tr>
        <td style="padding:10px;">Testimonial:</td>
        <td style="padding:10px;"><textarea name="description" cols="90" rows="5" id="description"><? echo $testimonial->vars["description"]; ?></textarea></td>
      </tr>      
      <tr>
        <? if(isset($testimonial_id)){ ?>
        <input name="testimonial_id" type="hidden" value="<? echo $testimonial->vars["id"]; ?>">
        <input name="update" type="hidden" id="update" value="Y">        
        <? } else { ?>
        <input name="save" type="hidden" id="update" value="Y">
        <? } ?>  
        <td style="padding:10px;">Person who gave the testimonial:</td>
        <td style="padding:10px;">
          <input name="person_name" type="text" id="person_name" value="<? echo $testimonial->vars["person_name"]; ?>" size="100">
        </td>
      </tr>               
      <tr>
        <td style="padding:10px;"></td>
        <td style="padding:10px;">
        <input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>    
  </form>       



</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>