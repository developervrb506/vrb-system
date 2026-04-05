<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_checklist")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Gambling Check List</title>
</head>
<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">



<?
if (isset($_POST["reason"])){

	$new = new 	_gambling_checklist();
	$new->vars['data'] = param('reason');
	$new->insert();
	
}

if (isset($_POST["delete"])){

	$del = get_gambling_checklist($_POST["delete"]);
	$del->delete();
	
}

?>

<? $list = get_all_gambling_checklist(); ?>

<span class="page_title">
	Gambling Check List
</span>
<br />

<div class="form_box">
  <form method="post" action="" id="forms" name="forms">
         	Add : <input name="reason" type="text" id="reason" size="100" /> <input name="asd" type="submit" id="asd" value="Add" />
  </form>

</div>

<p>
<? if(count($list)>0){ ?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sortable">
      <thead>
          <tr>
            <th class="table_header" align="center" style="cursor:pointer;">Data</th>
            <th class="table_header" align="center" style="cursor:pointer;">Delete</th>
          </tr>
      </thead>
      <tbody>
          <? $i=0; foreach($list as $rea){ $i++; ?>
              <? if($i % 2){$style = "1";}else{$style = "2";} ?>
              <tr>
                <td class="table_td<? echo $style ?>" align="center"><? echo $rea->vars["data"] ?></td>
                <td class="table_td<? echo $style ?>" align="center">
                    <form method="post" action="">    
                          <input name="delete" type="hidden" id="delete" value="<? echo $rea->vars["id"]; ?>" />
                          <input type="image" src="http://cashier.vrbmarketing.com/utilities/images/icons/trash.png" />                   
                    </form>
                </td>
        	  </tr>
          <? } ?>
      </tbody>
    </table>

<? }else{ echo "No information to show"; } ?>
</p>


</div>
<? include "/../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>