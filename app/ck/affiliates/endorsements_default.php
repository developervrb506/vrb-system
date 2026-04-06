<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Endorsement Default</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
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

function validate_adding(){	
	if(document.getElementById("endorsement").value == "" || document.getElementById("endorsement").value == " "){
		alert("The endorsement is required");	
		document.getElementById("endorsement").focus();
		return false;
	}		
	return true;	
}

function validate_delete(id){
	if(confirm('Are you sure you want to delete this record?')){
		location.href = './process/actions/endorsements_default_action.php?id=' + id;
	}
}

function update_endorsement_default(id){	
	location.href = 'endorsements_default.php?id=' + id;	
}
</script>

</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>

<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">


<?
if( isset($_GET["id"]) ) {	 
	 $end = get_endorsement_default_affiliate($_GET["id"]);
?> 	  
<div class="wrap">
<span class="page_title">Update Record</span><br /><br />
<br />
<?
$sportsbooks = get_all_affiliates_brands(true);

?>
<form method="post" action="./process/actions/endorsements_default_action.php" onsubmit="return validate_adding();" enctype="multipart/form-data">
    <input type="hidden" name="update" id="update" value="<? echo $end->vars["id"] ?>" />
   <input type="hidden" name="id" id="id" value="<? echo $end->vars["id"] ?>" />	
   Sportsbook: 
   <select name="text_book" id="text_book">
		  <? 
             foreach($sportsbooks as $book){ ?>
                 <option  <? if ($book->vars["id"]== $end->vars["idbook"]->vars["id"]){ echo ' selected="selected" ';}?> value="<? echo $book->vars["id"] ?>"><? echo $book->vars["name"] ?></option>
        <? } ?>
      </select>
   
   <br /><br />
   Endorsement: <textarea name="endorsement" id="endorsement" cols="55" rows="10"><? echo $end->vars["endorsement"] ?></textarea><br /><br />       
   <input name="" type="submit" value="Update" />    
</form>
</div>
  	  
<? } else { ?>
  
<div class="wrap">
<span class="page_title">Add Record</span><br /><br />
<br />
<?
$sportsbooks = get_all_affiliates_brands(true);

?>
<form method="post" action="./process/actions/endorsements_default_action.php" onsubmit="return validate_adding();" enctype="multipart/form-data">
   Sportsbook: <select name="text_book" id="text_book">
		  <? 
             foreach($sportsbooks as $book){ ?>
                 <option value="<? echo $book->vars["id"] ?>"><? echo $book->vars["name"] ?></option>
        <? } ?>
      </select><br /><br />
   Endorsement: <textarea name="endorsement" id="endorsement" cols="55" rows="10"></textarea><br /><br />     
   <input name="" type="submit" value="Add" />    
</form>
<br />
<br />
<table class="sortable" id="sort_table" style="cursor:pointer;">
     <thead>
        <tr>
            <th class="table_header" scope="col" style="text-align: center">ID</th>
            <th class="table_header" scope="col" style="text-align: center">Sportsbook</th> 
            <th class="table_header" scope="col" style="text-align: center">Endorsement</th>            
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Delete</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Edit</th>
        </tr>
    </thead>
    <tbody id="the-list">        
        <?
		$endorsements = get_all_endorsement_default_affiliate();
		/*echo "<pre>";
		print_r($endorsements);
		echo "</pre>";*/
		 foreach($endorsements as $end){ ?>
        <?
	    if($i % 2){$_style = "1";}else{$_style = "2";} $i++; 	 		    
		?>      
         <tr <? echo $style; ?>>
            <th class="table_td<? echo $_style ?>" valign="top" style="text-align: center"> <? echo $end->vars["id"]; ?></th>
            <th class="table_td<? echo $_style ?>" valign="top" style="text-align: center" nowrap="nowrap"> <? echo $end->vars["idbook"]->vars["name"]; ?></th>		
            <th class="table_td<? echo $_style ?>" valign="top" style="text-align: center"> <? echo $end->vars["endorsement"]; ?></th>	
            <th class="table_td<? echo $_style ?>" valign="top" style="text-align: center"> <input type="button" name="button" id="button" value="Click Here" onclick="validate_delete('<? echo $end->vars["id"]?>')"  /></th>
            <th class="table_td<? echo $_style ?>" valign="top" style="text-align: center"> <input type="button" name="button2" id="button2" value="Click Here" onclick="update_endorsement_default('<? echo $end->vars["id"] ?>')"  /></th>         </tr>        
         <? 
		  
		} ?>         
    </tbody>
</table>

<? } ?>

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>