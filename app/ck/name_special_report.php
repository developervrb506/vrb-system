<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("phone_admin")){ ?>
<?
$type = $_GET["type"];
switch($type){
	case "source":
		$title = "Source Changes Report";
		$field = "clerk_source";
		$head = "Clerk's Source";
	break;
	case "email":
		$title = "Email Requests Report";
		$field = "email_desc";
		$head = "What does he wants to receive?";
	break;
	case "reload":
		$title = "No Action Report";
		$field = "why_stop";
		$head = "Why stopped playing?";
	break;
}
$names = get_names_special_fields_report($field);
$i=0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?></title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px; width:3500px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>
	
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header">Name</td>  
        <td class="table_header">PlayerID</td> 
        <td class="table_header">Notes</td>       
        <td class="table_header"><? echo $head ?></td>
        <? if($type == "email"){ ?>
        <td class="table_header" align="center">Status</td>
        <? } ?>
        <td class="table_header" align="center">Calls</td>
        <td class="table_header" align="center">View</td>
      </tr>
      <? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
	  <? if($type == "email"){$request = get_email_request_by_name($name->vars["id"]);} ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["id"]; ?></td>
		<td class="table_td<? echo $style ?>"><? echo ucwords($name->full_name()); ?></td>  
        <td class="table_td<? echo $style ?>" align="center"><? echo $name->vars["acc_number"]; ?></td>
        <td class="table_td<? echo $style ?>">
			<?
			echo nl2br($name->vars["note"]); 
			if($request->vars["notes"] != ""){
				echo "<br />".nl2br($request->vars["notes"]);	
			}
			?>
            
        </td>    
        <td class="table_td<? echo $style ?>"><? echo $name->vars[$field]; ?></td> 
        <? if($type == "email"){ ?>
        <td class="table_td<? echo $style ?>" align="center"><? if ($request !== null) { echo $request->color_status(); } ?></td>
        <? } ?>       
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="http://localhost:8080/ck/calls.php?nid=<? echo $name->vars["id"]; ?>" target="_blank" class="normal_link">Calls</a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="http://localhost:8080/ck/edit_name.php?nid=<? echo $name->vars["id"]; ?>" target="_blank" class="normal_link">View</a>
        </td>        
      </tr>
      <? } ?>
      <tr>
        <td class="table_last" colspan="1000"></td>
      </tr>
    </table>


</div>
<? include "../includes/footer.php" ?>
<? } ?>