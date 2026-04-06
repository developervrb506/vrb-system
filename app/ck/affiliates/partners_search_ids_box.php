<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Search by Id</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
//Shadowbox.init(window.opener.location.reload(true));
</script>
<script type="text/javascript">
function reload_page(aid,site){
	
	var href = parent.location.href;
	 
	 if (href.indexOf('?') > -1){
  		 href += "&site="+site+"&aid="+aid;
	}else{
  		 href += "?site="+site+"&aid="+aid;
	 }
	 
	 
	parent.location = href;
	parent.location.assign(href);
	parent.Shadowbox.close();

}

</script>
</head>
<body>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Search by Id</span><br /><br />
<?


?>

<form method="post">

<input name="sid" type="text" id="sid" value="<? echo $_POST["sid"] ?>">&nbsp;&nbsp;

<select name="type" id="type">
 
  <option value="aid" <? if($_POST["type"] == "aid"){echo "selected";} ?>>aid</option>
   <option value="aff" <? if($_POST["type"] == "aff"){echo "selected";} ?>>aff</option>
 
</select>

<input type="submit" value="Search">

</form>
<br><br>

<?

switch($_POST["type"]){
	
	case "aid":
		$affiliate = get_affiliate_partner($_POST["sid"]);
		
		
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
            
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="100%" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th class="table_header" scope="col" nowrap="nowrap"><strong></strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Name</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Website</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>AF</strong></th>
               
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                <th class="table_td1"><input type="radio"  value="<? echo $affiliate->vars["id"] ?>" name ="aid" onchange="reload_page(this.value,'<? echo $_GET["site"] ?>')" /></th>
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
            
            <table id="sort_table" class="sortable" style="cursor:pointer;" width="100%" border="0" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th class="table_header" scope="col" nowrap="nowrap"><strong></strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Name</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>Website</strong></th>
                <th class="table_header" scope="col" nowrap="nowrap"><strong>AID</strong></th>
              
              </tr>
            </thead>
            <tbody id="the-list">
              <tr>
                 <th class="table_td1"><input type="radio"  value="<? echo $affiliate->vars["id"] ?>" name ="aid" onchange="reload_page(this.value,'<? echo $_GET["site"] ?>')" /></th>
                <th class="table_td1"><? echo ucwords($affiliate->full_name()); ?></th>
                <th class="table_td1"><? echo $affiliate->vars["websitename"] ?></th>
                <th class="table_td1"><? echo $affiliate->vars["id"]				 ?></th>
               
              </tr>
            </tbody>
          </table>
            <?
		}else{
			echo "Affiliate not found.";
		}
	break;
	
}

?>





</div>

<? } else { echo "ACCESS DENIED"; }?>