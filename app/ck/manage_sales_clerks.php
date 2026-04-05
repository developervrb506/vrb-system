<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$name = "Clerks";
if(isset($_GET["uid"])){
	$update = true;
	$user = get_clerk($_GET["uid"]);
	$name = $user->vars["name"];
}else if(isset($_POST["update"])){
	$user = get_clerk($_POST["update"]);
	$user->vars["level"] = $_POST["type"];
	$user->update(array("level"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Manage <? echo $name ?></title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Manage <? echo $name ?></span><br /><br />

<? include "includes/print_error.php" ?>

<? if($update){ ?>
<div class="form_box" style="width:450px;">
	<form method="post" action="?e=35">
   <input name="update" type="hidden" id="update" value="<? echo $user->vars["id"] ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td><strong>Type:</strong></td>
        
        <td>
        	<table width="180" border="0" cellspacing="0" cellpadding="5">
        	<?
			$levels = get_all_ck_levels(true);
			foreach($levels as $level){
				if(!$level->vars["sale_manager"]){		
				?>
				
                  <tr>
                    <td><? echo $level->vars["name"] ?></td>
                    <td><input name="type" id="type" <?
					 	if($user->vars["level"]->vars["id"] == $level->vars["id"]){echo 'checked="checked"';} 
					 ?> type="radio" value="<? echo $level->vars["id"] ?>" /></td>
                  </tr>
                
				<?
				}
			}
			?>
            </table>
        </td>
      </tr>     
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
<? }else{ ?>
<? $clerks = get_all_clerks("","2,4,5") ?>
<div class="form_box" style="width:650px;">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">Level</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
      
      <tr>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["level"]->vars["name"]; ?></td>
        
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
            <a class="normal_link" href="?uid=<? echo $clerk->vars["id"]; ?>">Edit</a>
        </td>
      </tr>
      
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
    </table>
</div>
<? } ?>

</div>
<? include "../includes/footer.php" ?>