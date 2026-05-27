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
<!--
function confirmation(ID) {
	var answer = confirm("Are you sure that you want to delete this partner?");
	if (answer){		
	   window.location = "process/actions/partners_affiliate_delete.php?affid="+ID;
	}	
}
//-->

</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
</head>
<body>
<? $page_style = " width:2000px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Manage Partners</span><br /><br />

<?
 
if (isset($_GET["e"])) { echo get_error($_GET["e"]); }
?>
<br />
<table id="sort_table" class="sortable" style="cursor:pointer;" width="500" border="0" cellspacing="1" cellpadding="1">
<thead>
  <tr>
    <th class="table_header"  scope="col" nowrap="nowrap"><strong>Id</strong></th>
    <th class="table_header"  scope="col" nowrap="nowrap"><strong>Partner's Name</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Website's Name</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Email</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Referrer Affiliate</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>Clerk</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>WW</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>SBO</strong></th>
   <?php /*?> <th class="table_header" scope="col" nowrap="nowrap"><strong>OWI</strong></th><?php */?>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>PBJ</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>BITBET</strong></th>
    <th class="table_header" scope="col" nowrap="nowrap"><strong>HRB</strong></th>
    <?php /*?><th class="table_header"  scope="col" nowrap="nowrap"><strong>BETLION365</strong></th><?php */?>
    <th class="table_header"  scope="col" nowrap="nowrap"><strong>COMMISSION PARTNERS</strong></th>
    <? if(isset($_GET["count"])){ ?><th class="table_header" scope="col" nowrap="nowrap"><strong>Customers Count</strong></th><? } ?>
    <th scope="col" nowrap="nowrap" class="table_header sorttable_nosort">&nbsp;</th>
    <th scope="col" nowrap="nowrap" class="table_header sorttable_nosort">&nbsp;</th>   
  </tr>
</thead>
<tbody id="the-list">
  <?
  $dnc_affiliates = false;
  $affiliates = get_all_affiliates_partners($dnc_affiliates);
  $aff_code =  get_all_affiliates_code();
  $books = array();
        
	$books["wagerweb"] = 1;
    $books["sbo"]= 3;
	$books["owi"]= 7;
	$books["pbj"]= 6;
	$books["bitbet"]= 8;
	$books["hrb"]= 9;
	//$books["betlion"]= 10;
	$books["CP"]= 12;
		
	
 foreach($affiliates as $aff){ ?>
     <?
	    if($i % 2){$style = "1";}else{$style = "2";} $i++; 
		
		$clerk="";
		if ($aff->vars["clerk"]){
		  $clerk = get_clerk($aff->vars["clerk"]) ;
		
		}
		
		
    ?>   
      <tr>
        <th class="table_td<? echo $style ?>"><? echo $aff->vars["id"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo ucwords($aff->full_name()); ?></th>
        <th class="table_td<? echo $style ?>" style="font-size:11px;"><? echo $aff->vars["websitename"] ?></th>
        <th class="table_td<? echo $style ?>" style="font-size:11px;"><? echo $aff->vars["email"] ?></th>
        <th class="table_td<? echo $style ?>" style="font-size:11px;">
		<? 
		$af_code = get_affiliate_code_partner($aff->vars["referrer"],3,$aff->vars["sub"]); 
		echo $af_code["affiliatecode"];
		?>
        </th> 
        <th class="table_td<? echo $style ?>" style="font-size:11px;"><? echo $clerk->vars["name"] ?></th>           
        <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["wagerweb"]."_".$aff->vars["id"]]["affiliatecode"]; ?></th>
        <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["sbo"]."_".$aff->vars["id"]]["affiliatecode"]; ?></th>
        <?php /*?><th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["owi"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th><?php */?>
        <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["pbj"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th>
        <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["bitbet"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th>
        <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["hrb"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th>
        <?php /*?><th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["betlion"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th><?php */?>
         <th class="table_td<? echo $style ?>" ><? echo $aff_code[$books["CP"]."_".$aff->vars["id"]]["affiliatecode"];  ?></th>                
        <!--<th><? //echo get_affiliate_password($aff->id,1); ?></th>    -->
        <? if(isset($_GET["count"])){ ?><th class="table_td<? echo $style ?>" ><? //echo $aff->get_wagerweb_active_accounts() ?></th> <? } ?> 
        <th class="table_td<? echo $style ?>" ><a href="partners_affiliate_detail.php?affid=<? echo $aff->vars["id"] ?>" target="_blank">Edit</a></th>
        <th class="table_td<? echo $style ?>" ><a href="javascript:confirmation(<? echo $aff->vars["id"] ?>)">Delete</a></th>    
      </tr>
  <?  } ?>
 </tbody>
</table>




</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>