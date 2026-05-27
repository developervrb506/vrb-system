<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage Partners</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"firstname",type:"null", msg:"The first name is required"});
validations.push({id:"lastname",type:"null", msg:"The last name is required"});
validations.push({id:"address",type:"null", msg:"The address is required"});
validations.push({id:"city",type:"null", msg:"The city is required"});
validations.push({id:"state",type:"null", msg:"The state is required"});
validations.push({id:"country",type:"null", msg:"The country is required"});
validations.push({id:"zipcode",type:"null", msg:"The zipcode is required"});
validations.push({id:"email",type:"email", msg:"You need to write a valid Email"});
validations.push({id:"phone",type:"null", msg:"The phone number is required"});
//validations.push({id:"websitename",type:"null", msg:"The website name is required"});
validations.push({id:"websiteurl",type:"null", msg:"The website url is required"});
validations.push({id:"password2",type:"compare:password", msg:"Both passwords must be the same"});
validations.push({id:"cks_books",type:"checkbox:checkbook,1", msg:"You must choose at least one sportsbook"});
</script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Manage Partners</span><br /><br />

<? 
$affiliates = get_affiliate_partner($_GET["affid"]);

if($affiliates->vars["sub"] > 0){$readonly = " readonly "; $disabled = " disabled ";}


//echo "<pre>";
//print_r($affiliates);
//echo "</pre>";


$title = $affiliates->full_name();


if (isset($_GET["e"])) { echo get_error($_GET["e"]); }

$clerks = get_all_clerks_by_group(6);

?>
<p>
<?
if($affiliates->vars["sub"] == 0){
	echo "Edit website: ";
	$subwebs = get_affiliates_sub_websites($affiliates->vars["id"]);
	foreach($subwebs as $subw){
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
		?> <a target="_blank" href="<?= BASE_URL ?>/ck/affiliates/partners_affiliate_detail.php?affid=<? echo $subw["id"] ?>">
			<? echo $subw["websitename"] ?>
        </a> <?
		
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	}
}
?>
</p>
<br />
<form action="./process/actions/partners_affiliate_action.php?edit" method="POST"  enctype="multipart/form-data" name="join" id="join" onSubmit="return validate(validations);">  
  <table width="100%" cellpadding="2" cellspacing="2">    
    <tr>
      <td>First Name:</td>
      <td><input type="text" <? echo $readonly ?> name="firstname" id="firstname" size="50" maxlength="50" value="<? echo $affiliates->vars["firstname"]; ?>"></td>
    </tr>
    <tr>
      <td>Last Name:</td>
      <td><input type="text" <? echo $readonly ?> name="lastname" id="lastname" size="50" maxlength="50" value="<? echo $affiliates->vars["lastname"]; ?>"></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input type="text" <? echo $readonly ?> name="address" id="address" size="50" maxlength="100" value="<? echo $affiliates->vars["address"]; ?>"></td>
    </tr>
    <tr>
      <td>City:</td>
      <td><input type="text" <? echo $readonly ?> name="city" id="city" size="50" maxlength="250" value="<? echo $affiliates->vars["city"]; ?>"></td>
    </tr>
    <tr>
      <td>State:</td>
      <td><input type="text" <? echo $readonly ?> name="state" id="state" size="50" maxlength="100" value="<? echo $affiliates->vars["state"]; ?>"></td>
    </tr>
    <tr>
      <td>Country:</td>
      <td><input type="text" <? echo $readonly ?> name="country" id="country" size="50" maxlength="100" value="<? echo $affiliates->vars["country"]; ?>"></td>
    </tr>
    <tr>
      <td>Zip Code:</td>
      <td><input type="text" name="zipcode" id="zipcode" size="50" maxlength="50" value="<? echo $affiliates->vars["zipcode"]; ?>"></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" <? echo $readonly ?> name="email" id="email" size="50" maxlength="100" value="<? echo $affiliates->vars["email"]; ?>"></td>
    </tr>
     <tr>
      <td>Clerk: </td>
      <td>
       <select name="clerk" <? echo $disabled ?> >
           <option  value="0"><? if($affiliates->vars["clerk"]){ echo "Remove a Clerk"; } else { echo "Assign a Clerk"; }?></option>
        <? $i =1;
		foreach ($clerks as $clerk){ ?>
		   <option value="<? echo $clerk->vars["id"] ?>" <? if ($clerk->vars["id"] == $affiliates->vars["clerk"]){ echo "selected"; } ?>   ><? echo $clerk->vars["name"] ?></option>';	
	    <? } ?>
        
       </select>
             </td>
    </tr>
    
    
    <tr>
      <td>Phone:</td>
      <td><input type="text" <? echo $readonly ?> name="phone" id="phone" size="50" maxlength="255" value="<? echo $affiliates->vars["phone"]; ?>"></td>
    </tr>
    <?php /*?><tr>
      <td>Website Name:</td>
      <td><input type="text" name="websitename" id="websitename" size="50" maxlength="255" value="<? echo $affiliates->vars["websitename"]; ?>"></td>
    </tr><?php */?>
    <tr>
      <td>Website URL:</td>
      <td><input type="text" name="websiteurl" id="websiteurl" size="50" maxlength="255" value="<? echo $affiliates->vars["websiteurl"]; ?>"></td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
    <?php /*?><tr>
      <td>Affiliate's password:</td>
      <td><strong><? echo $affiliates->vars["password"]; ?></strong></td>
    </tr>
<?php */?>
    <tr>
    <td>
    	Profile Image (157px X 77 px):  <br>
        
    </td>
     <td>
     <? if  ($affiliates->vars["image"] != "no_image") { ?>
    <img src="http://jobs.inspin.com/partners/images/affiliates_images/<? echo $affiliates->vars["image"] ?>" width="157" height="77" />
    <? } ?>
    <input  readonly="readonly" name="ufile" type="file" id="ufile" />
     </td>
    </tr>
   
    <?php /*?><?
	$books = get_sportsbooks_by_affiliate_partner($affiliates->vars["id"]);
	$aff_books = "";
	foreach($books as $af_book){
		$aff_books .= "-" . $af_book["id"];
	?>
    
    <tr>
      <td><br><br><strong><? echo ucwords($af_book["name"]) ?></strong></td>
      <td></td>
    </tr>
    <tr>
      <td><? echo ucwords($af_book["name"]) ?> Affiliate Code:</td>
      <? $af_code = get_affiliate_code_partner($affiliates->vars["id"],$af_book["id"],$affiliates->vars["sub"]);
	     $af_pass = get_affiliate_password_partner($affiliates->vars["id"],$af_book["id"],$affiliates->vars["sub"]);
	  ?>
      
      <td><input type="text" <? echo $readonly ?> name="affcode_<? echo $af_book["id"] ?>" id="affcode_<? echo $af_book["id"] ?>" size="50" maxlength="255" value="<? echo $af_code["affiliatecode"]  ?>"></td>
    </tr>
    <tr>
      <td><? echo ucwords($af_book->name) ?> Affiliate Password:</td>
      <td><input type="text" <? echo $readonly ?> name="affpassword_<? echo $af_book["id"] ?>" id="affpassword_<? echo $af_book["id"] ?>" size="50" maxlength="255" value="<? echo $af_pass["password"]; ?>"><br><br></td>
    </tr>   
    
    <?
	}
	?><?php */?>
    
    <?
	$books = get_sportsbooks_by_affiliate_partner($affiliates->vars["id"]);
	$aff_books = "";
	$i=0;
	foreach($books as $af_book){$i++;
		$aff_books .= "-" . $af_book["id"];
	?>    
    
    <? if ($i == 1){ ?>
    <tr>
      <td>Affiliate Code:</td>
      <? 
	  $af_code = get_affiliate_code_partner($affiliates->vars["id"],$af_book["id"],$affiliates->vars["sub"]);
	  ?>      
      <?php /*?><td><input type="text" <? echo $readonly ?> name="affcode_<? echo $af_book["id"] ?>" id="affcode_<? echo $af_book["id"] ?>" size="50" maxlength="255" value="<? echo $af_code["affiliatecode"]  ?>"></td><?php */?>
      <td><input type="text" <? echo $readonly ?> name="affcode" id="affcode" size="50" maxlength="255" value="<? echo $af_code["affiliatecode"]; ?>"></td>
    </tr>     
    <? } ?>
    <?
	}
	?>
    
    <tr>
      <td>Affiliate's password:</td>
      <td><strong><? echo $affiliates->vars["password"]; ?></strong></td>
    </tr>   
      
    <?	
	$sportsbooks = get_all_sportsbooks_partner();
	if ( count($sportsbooks) > 0 && $affiliates->vars["sub"] == 0) {
	?>  
    <tr>
      <td><input name="aff_books" <? echo $readonly ?> type="hidden" id="aff_books" value="<? echo substr($aff_books,1) ?>">Related sportsbooks:</td>
      <td>
      <div id="cks_books">      
	   <? foreach($sportsbooks as $book) {	   
	   $return = check_book_affiliate($affiliates->vars["id"], $book["id"]);	
	   ?>
	   <? if ($return == TRUE) { ?>	   
        <input checked type="checkbox" <? echo $readonly ?> name="chkboxes[]" id="checkbook_<? echo $book["id"] ?>" value="<? echo $book["id"] ?>">&nbsp;<? echo $book["name"] ?>           <br />     
       <? } else { ?>
        <input type="checkbox" <? echo $readonly ?> name="chkboxes[]" id="checkbook_<? echo $book["id"] ?>" value="<? echo $book["id"] ?>">&nbsp;<? echo $book["name"] ?>  
         <br />
       <? } ?>        
      <? } ?>
      </div>       
      </td>
    </tr> 
    <? } ?>
    <tr>
      <td colspan="2" height="15"><input type="hidden" name="id" id="id" value="<? echo $affiliates->vars["id"] ?>"></td>      
    </tr>   
    <tr>
      <td colspan="2"><strong>Change Affiliate's Password:</strong></td>      
    </tr>    
    <tr>
      <td>Affiliate's Password:</td>
      <td><input type="text" <? echo $readonly ?> name="password" id="password" size="50" maxlength="64"></td>
    </tr>
    <tr>
      <td>Affiliate's Password (again):</td>
      <td><input type="text" <? echo $readonly ?> name="password2" id="password2" size="50" maxlength="64"></td>
    </tr> 
    <tr>
      <td colspan="2"><br><br><strong>Admin Comments:</strong></td>      
    </tr>    
    <tr>
      <td>Comments:</td>
      <td><textarea <? echo $readonly ?> name="comments" cols="45" rows="10" id="comments"><? echo $affiliates->vars["comments"] ?></textarea></td>
    </tr>     
    <tr>
      <td colspan="2"><input type="submit" name="submit" id="submit" value="Save"></td>
    </tr>
  </table>
</form>

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>