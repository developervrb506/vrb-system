<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("inactive_affiliates_banners")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Inactive Banners</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Inactive Banners</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d", strtotime(date("Y-m-d")." -1 year"));}
?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />

<? 
$banners = get_inactive_affiliates_banners($from); 
$campaigns = get_all_affiliates_campaigns();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header">Campaign</td>
    <td class="table_header" align="center">Size</td>
    <td class="table_header" align="center">Image</td>
  </tr>
  <?
    foreach($banners as $banner){
          if($i % 2){$style = "1";}else{$style = "2";}$i++;
          ?>
          <tr>
              <td class="table_td<? echo $style ?>" align="center"><? echo $banner->vars["id"]; ?></td> 
              <td class="table_td<? echo $style ?>"><? echo $campaigns[$banner->vars["idcampaigne"]]->vars["name"]; ?></td> 
              <td class="table_td<? echo $style ?>" align="center">
			  	<? echo get_affiliate_banner_size_by_name($banner->vars["name"]); ?>
              </td> 
              <td class="table_td<? echo $style ?>" align="center">
              	<a href="http://www.inspin.com/partners/images/banners/<? echo $banner->vars["name"] ?>" target="_blank">
                <img src="http://www.inspin.com/partners/images/banners/<? echo $banner->vars["name"] ?>" style="max-height:200px; max-width:200px;" />
                </a>
                
                <?php /*?><a href="http://images.commissionpartners.com/data/banners/<? echo $banner->vars["name"] ?>" target="_blank">
                <img src="http://images.commissionpartners.com/data/banners/<? echo $banner->vars["name"] ?>" style="max-height:200px; max-width:200px;" />
                </a><?php */?>
              </td> 
              </tr>	
          <?
    }
    ?>
        </tr>	
        <tr>
          <td class="table_last" colspan="100"></td>
        </tr>
    
    </table>

</div>
<? include "../includes/footer.php" ?>

<? }else{ echo "Access Denied"; }?>