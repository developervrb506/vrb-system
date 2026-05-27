<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners Approve</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">
<!--
function delete_partner(ID) {
	var answer = confirm("Are you sure that you want to delete this partner?");
	if (answer){		
	   window.location = "process/actions/partners_affiliate_delete.php?approve=1&affid="+ID;
	}	
}
//-->
</script>
</head>
<body>
<? $page_style = " width:1200px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Partners Approve</span><br /><br />

<br />
<table style="cursor:pointer;" class="sortable" width="500" border="0" cellspacing="1" cellpadding="1">
<thead>
  <tr>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>First Name</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Last Name</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Email</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>The applicant's Website URL</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Sportsbook</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap" class="sorttable_nosort"></th>
    <th class="table_header" scope="col" nowrap="nowrap" class="sorttable_nosort"></th>
  </tr>
</thead>
<tbody id="the-list">
  <?
  $books = get_all_affiliates_brands(true);
  $pendings = get_affiliates_pending_approval();
  foreach($pendings as $pend){
	   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
     
  ?>
  <tr>
    <th class="table_td<? echo $style ?>"><? echo $pend->vars["firstname"] ?></th>
    <th class="table_td<? echo $style ?>"><? echo $pend->vars["lastname"] ?></th>
    <th class="table_td<? echo $style ?>"><? echo $pend->vars["email"] ?></th>
    <th class="table_td<? echo $style ?>"><? echo $pend->vars["websiteurl"] ?></th>
    <th class="table_td<? echo $style ?>"><? echo $books[$pend->vars["idbook"]]->vars["name"]; ?></th>
    
    <th class="table_td<? echo $style ?>"><a href="partners_approve_details.php?affid=<? echo $pend->vars["id"]; ?>&bookid=<? echo $pend->vars["idbook"]?>">Approve</a></th>    
    <th nowrap="nowrap" class="table_td<? echo $style ?>"><a href="javascript:;" onClick="delete_partner('<? echo $pend->vars["id"] ?>');">Delete Partner</a></th>
  </tr>
  <? } ?>
</tbody>
</table>



</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>