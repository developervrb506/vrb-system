<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Custom Promotype</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"link_text",type:"null", msg:"You need to enter a Text for the link"});
validations.push({id:"link_url",type:"null", msg:"You need to enter a Target for the link"});
</script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<script type="text/javascript" >
function email_template(value){
	

if (value == "e"){
	document.getElementById("cat_div").style.display = "block";
	}
else {
	document.getElementById("cat_div").style.display = "none";
	}	
	
}


</script>


<?
$edit = false;
if (isset($_GET["id"])){
 $edit = true;
 $id = $_GET["id"];
}
?>

</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add New Promotype</span><br /><br />
<div align="right"><span ><a href="partners_custom_promotype_view.php">Back</a></span></div>

<!-- Contenido -->

<?
$sportsbooks = get_all_affiliates_brands(true);


if ($edit){
	
 $promotype = get_promotype_by_id($id);
 
   $promo = explode("_-_",$promotype->vars["name"]);
  
    if ($promotype->vars["type"] == "e"){
	  $email = explode("_",$promo[0]);
	  $cat = $email[0];	
	  $name = $email[1];
	 
	}
	else {
	  $name = $promo[0];	
	}
	$type = $promotype->vars["type"];
	$url = $promo[2];
	$idbook = $promo[3];
  

	
}

?>

<form method="post" action="./process/actions/add_book_custom_promotype_action.php" onSubmit="return validate(validations);">
    
    <? if ($edit) { ?>
     <input type="hidden" name="edit" value="<? echo $id ?>" />
	<? } ?>
    <div id="text_div">Type:
    <select name="type" onchange="email_template(this.value)">
    <option  value="0" >Select a Type</option>
    <option  <? if ($type == "a"){ echo ' selected="selected" ';}?>  value="a">Articles</option>
    <option  <? if ($type == "e"){ echo ' selected="selected" ';}?>  value="e">Email Template</option>
    <option  <? if ($type == "i"){ echo ' selected="selected" ';}?>  value="i">Infografics</option>
    <option  <? if ($type == "p"){ echo ' selected="selected" ';}?>  value="p">PressRelease</option>
    <option  <? if ($type == "v"){ echo ' selected="selected" ';}?>  value="v">Video</option>
    
    </select>
    </div> <br />
    <div id="cat_div" <? if ($type != 'e') { echo ' style="display:none '; } ?>">Category:
    <select name="cat">
    <option value="0" >Select a Category</option>
    <option  <? if ($cat == "Acquisition"){ echo ' selected="selected" ';}?>   value="Acquisition">Acquisition</option>
    <option  <? if ($cat == "Conversion"){ echo ' selected="selected" ';}?> value="Conversion">Conversion</option>
    <option  <? if ($cat == "Product"){ echo ' selected="selected" ';}?> value="Product">Product</option>
    <option  <? if ($cat == "Retention"){ echo ' selected="selected" ';}?> value="Retention">Retention</option>
    <option  <? if ($cat == "Reactivation"){ echo ' selected="selected" ';}?> value="Reactivation">Reactivation</option>
    
    </select>
    </div> <br />
    
    
    
     <div id="text_div">Book:
    
    	<select name="text_book" id="text_book">
		  <? 
             foreach($sportsbooks as $book){ ?>
                 <option <? if ($idbook == $book->vars["id"]){ echo ' selected="selected" ';}?>  value="<? echo $book->vars["id"] ?>"><? echo $book->vars["name"] ?></option>
        <? } ?>
      </select>
    
    </div><br />
    <div id="text_div">Name:<br>
    <input name="link_text" type="text" id="link_text" style="width:500px;" value="<? echo $name ?>" /></div>
    <br />
    <div id="text_div">Target URL:<br>
    <input name="link_url" type="text" id="link_url" style="width:500px;" value="<? echo $url ?>" /></div>
    <br />
   
    <br /><br />
    <input name="" type="submit" value="Save" />
</form>
<!-- Fin Contenido -->

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>