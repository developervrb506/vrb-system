<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upid = get_betting_proxy(param("update_id"));
		$upid->vars["name"] = param("name");
		$upid->vars["ip"] = param("ip");
		$upid->vars["port"] = param("port");
		$upid->vars["user"] = param("user");
		$upid->vars["password"] = param("password");
		$upid->update();
	}else{
		$newid = new _betting_proxy();
		$newid->vars["name"] = param("name");
		$newid->vars["ip"] = param("ip");
		$newid->vars["port"] = param("port");
		$newid->vars["user"] = param("user");
		$newid->vars["password"] = param("password");
		$newid->insert();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Proxys</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$identifier = get_betting_proxy(param("idf"));
	if(is_null($identifier)){
		$title = "Add new Proxy";
	}else{
		$title = "Edit Proxy";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$identifier->vars["id"] .'" />';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"name",type:"null", msg:"Name is required"});
	validations.push({id:"ip",type:"null", msg:"IP is required"});
    </script>
	<div class="form_box" style="width:400px;">
        <form method="post" action="betting_proxys.php?e=40" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td><input name="name" id="name" value="<? echo $identifier->vars["name"] ?>" /></td>
          </tr>
          <tr>
            <td>IP</td>
            <td><input name="ip" id="ip" value="<? echo $identifier->vars["ip"] ?>" /></td>
          </tr>
          <tr>
            <td>Port</td>
            <td><input name="port" id="port" value="<? echo $identifier->vars["port"] ?>" /></td>
          </tr>
          <tr>
            <td>User</td>
            <td><input name="user" id="user" value="<? echo $identifier->vars["user"] ?>" /></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input name="password" id="password" value="<? echo $identifier->vars["password"] ?>" /></td>
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
    <span class="page_title">Betting Proxys</span><br /><br />
    <a href="?detail" class="normal_link">+ Add Proxy</a><br /><br />
	<? include "includes/print_error.php" ?>    
	<table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Name</td>
        <td class="table_header" align="center">IP</td>
        <td class="table_header" align="center">Port</td>
        <td class="table_header" align="center">User</td>
        <td class="table_header" align="center">Pass</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $identifiers = get_all_betting_proxys();
	   foreach($identifiers as $idf){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["ip"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["port"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["user"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $idf->vars["password"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&idf=<? echo $idf->vars["id"]; ?>" class="normal_link">Edit</a>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last" colspan="100"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>