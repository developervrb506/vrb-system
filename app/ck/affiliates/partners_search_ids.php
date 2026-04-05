<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Search by Id</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Search by Id</span><br /><br />


<form method="post">

<input name="sid" type="text" id="sid" value="<? echo $_POST["sid"] ?>">&nbsp;&nbsp;

<select name="type" id="type">  
  <option value="pid" <? if($_POST["type"] == "pid"){echo "selected";} ?>>pid</option>
  <option value="aid" <? if($_POST["type"] == "aid"){echo "selected";} ?>>aid</option>
  <option value="aff" <? if($_POST["type"] == "aff"){echo "selected";} ?>>aff</option>
  <option value="cid" <? if($_POST["type"] == "cid"){echo "selected";} ?>>cid</option>
</select>

<input type="submit" value="Search">

</form>
<br><br>

<?

switch($_POST["type"]){
	case "pid":
	
	    if (is_numeric($_POST["sid"])){
		  $promo = get_promotype_by_id($_POST["sid"]);
		}	
		
		if(!is_null($promo)){
			?>
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="500" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th  class="table_header"  scope="col"><strong>Type</strong></th>
                <th class="table_header"  scope="col"><strong>Content</strong></th>
                <th  class="table_header" scope="col"><strong>Campaign</strong></th>                
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                <? if($promo->vars["type"] == "b"){ ?>
                <th  class="table_td1" >Banner (<? echo $promo->get_size() ?>)</th>
                <th class="table_td1"><img src="http://www.inspin.com/partners/images/banners/<? echo $promo->vars["name"] ?>" />
                <?php /*?><img src="http://images.commissionpartners.com/data/banners/<? echo $promo->vars["name"] ?>" /><?php */?>
                </th>
                <? }else if($promo->vars["type"] == "t"){ ?>                
                <th class="table_td1" >Text Link <strong>&nbsp;(PID:&nbsp;</strong><? echo $promo->vars["id"] ?>)</th>
        		<th class="table_td1"><? $parts = explode("_-_",$promo->vars["name"]); echo $parts[0]; ?></th>
                <? }else{ ?>                
                <th class="table_td1">Other</th>
        		<th class="table_td1"><? $parts = explode("_-_",$promo->vars["name"]); echo $parts[0]; ?></th>
                <? } ?>
                <th  class="table_td1" colspan="2">
				<?
				$camp = get_campaign_by_id($promo->vars["idcampaigne"]);
				echo $camp->vars["name"];				
			    ?>
                </th>
              </tr>
            </tbody>
          </table>
          
            <?
			
		}else{
			echo "Product not found.";
		}
	break;
	case "aid":
	
	    if (is_numeric($_POST["sid"])){		
		   $affiliate = get_affiliate_partner($_POST["sid"]);
		}		
		
		//$affiliate_code = get_affiliate_code($_POST["sid"],1);
		if(!is_null($affiliate)){
			$aff_books = get_sportsbooks_by_affiliate_partner($_POST["sid"]);
			$aff_book= array();
			foreach ($aff_books as $books){
			 	
			 $affiliate_code = get_affiliate_code_partner($_POST["sid"],$books["id"]);
			  $aff_book[$affiliate_code["affiliatecode"]] = $affiliate_code["affiliatecode"];
			
			 
			}
			
			if(is_null($affiliate_code)){
		  			 $affiliate_code = get_affiliate_code_lead("aff_id",$affiliate->vars["email"]);
 			          $aff_book[$affiliate_code->vars["aff_id"]] = $affiliate_code->vars["aff_id"];
					  $affiliate_code = get_affiliate_code_lead("ww_af",$affiliate->email);
 			          if (!is_null($affiliate_code)){
					  		$aff_book[$affiliate_code->vars["ww_af"]] = $affiliate_code->vars["ww_af"];
					  }
			   }
			?>
            
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="500" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Name</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Website</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>AF</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>View</strong></th>
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                <th class="table_td1"><? echo ucwords($affiliate->full_name()); ?></th>
                <th class="table_td1"><? echo $affiliate->vars["websitename"] ?></th>
                <th class="table_td1"><?
				    $k=1; 
				    foreach ($aff_book as $_book){
					   echo $_book;
					   if ($k < count($aff_book)) echo ", ";
					 $k++;	
					}
				 
				 ?></th>
                <th class="table_td1"><a href="partners_affiliate_detail.php?affid=<? echo $affiliate->vars["id"] ?>" target="_blank">View / Edit</a></th>
              </tr>
            </tbody>
          </table>
            <?
		}else{
			echo "Affiliate not found.";
		}
	break;
	case "aff":
		$affiliate = get_affiliate_aid_by_code($_POST["sid"]);
		
		
		//$affiliate_code = get_affiliate_code($_POST["sid"],1);
		if(!is_null($affiliate)){
			
			?>
            
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="500" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Name</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Website</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>AID</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>View</strong></th>
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                <th class="table_td1"><? echo ucwords($affiliate->full_name()); ?></th>
                <th class="table_td1"><? echo $affiliate->vars["websitename"] ?></th>
                <th class="table_td1"><? echo $affiliate->vars["id"]				 ?></th>
                <th class="table_td1"><a href="partners_affiliate_detail.php?affid=<? echo $affiliate->vars["id"] ?>" target="_blank">View / Edit</a></th>
              </tr>
            </tbody>
          </table>
            <?
		}else{
			echo "Affiliate not found.";
		}
	break;
	case "cid":
		$campaign = get_campaign_by_id($_POST["sid"]);
		if(!is_null($campaign)){
			
			if ($campaign->vars["affiliate"] > 0){
			  $affiliate = get_affiliate_partner($campaign->vars["affiliate"]);
			  $affiliate_name =  ucwords($affiliate->full_name());
			}
			?>
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="500" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Name</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Description</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Affiliate</strong></th>
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                <th class="table_td1"><? echo $campaign->vars["name"]; ?></th>
                <th class="table_td1"><? echo $campaign->vars["desc"] ?></th>
                <th class="table_td1" ><a href="partners_affiliate_detail.php?affid=<? echo $campaign->vars["affiliate"] ?>" target="_blank"><? echo $affiliate_name ?></a></th>
              </tr>
            </tbody>
          </table>
            <?
		}else{
			echo "Custom Campaign not found.";
		}
	break;
}

?>





</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>