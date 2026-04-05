<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<script type="text/javascript">
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
Shadowbox.init();
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SEO Leads</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Leads</span><br /><br />

<? include "includes/print_error.php" ?>

<? if($current_clerk->im_allow("seo_other_clerk_leads")){ ?>
<p>
View 
<? $clerks = get_all_clerks_index("", "", false,true); ?>
<select onChange="location.href = '?cl='+this.value;">
  <option value="">My</option>
  <? foreach($clerks as $clk){ if($clk->im_allow("seo_system") && $current_clerk->vars["id"] != $clk->vars["id"]){ ?>
  <option <? if($_GET["cl"] == $clk->vars["id"]){?> selected="selected" <? } ?> value="<? echo $clk->vars["id"] ?>"><? echo $clk->vars["name"] ?></option>
  <? }} ?>
</select>
 Leads
</p>
<br /><br />
<? } ?>

<a href="process/actions/seo_get_lead.php" class="normal_link">Get New Lead</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="seo_manual_lead.php" class="normal_link">Manual Lead</a>
<br /><br />

<? if($_GET["cl"] != ""){$current_clerk = get_clerk($_GET["cl"]);} ?>

<? if($current_clerk->im_allow("seo_check_paid_links")){ ?>
<strong>Links Ready to be checked</strong>
<? $paid_leads = get_ready_paid_links($current_clerk->vars["id"]); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Brand</td>
    <td class="table_header" align="center">Target URL</td>
    <td class="table_header" align="center">Keywords</td>
    <td class="table_header" align="center">Rank</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Method</td>
    <td class="table_header" align="center">Paid Date</td>
    <td class="table_header" align="center">Article</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Article URL</td>
    <td class="table_header" align="center"></td>
  </tr>
  <? foreach($paid_leads as $group){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  <tr>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["brand"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["url"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["keywords"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["rank"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["amount"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["email"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["method"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;">
    <?
     if ( $group->vars["paid_date"] != "0000-00-00" ) { 
       echo date("Y-m-d", strtotime($group->vars["paid_date"]));
     }
    ?>    
    </td> 
    
    <td class="table_td<? echo $style_color ?><? echo $style ?>">
        <? if($group->vars["article"] != ""){ ?> <a href="csv/<? echo $group->vars["article"] ?>" target="_blank">View</a> <? } ?>
        <p>URL: <? echo $group->vars["article_url"] ?>"</p>
    </td> 
    
    <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["paid_comments"]; ?></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>"><input name="aurl_<? echo $group->vars["id"] ?>" type="text" id="aurl_<? echo $group->vars["id"] ?>" /></td>
    <td class="table_td<? echo $style_color ?><? echo $style ?>">
        <input name="" type="button" value="Checked" class="red_btn" onClick="if(confirm('Are you sure you want to mark it as Cheked?')){location.href = 'process/actions/seo_paid_ready.php?eid=<? echo $group->vars["id"] ?>&status=ck&complete=1&aurl='+encodeURIComponent(document.getElementById('aurl_<? echo $group->vars["id"] ?>').value);}" />
    </td> 
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>
<br /><br />
<? } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="5">

  <tr>
    <td colspan="2"  class="table_header">PAID LINKS</td>
    </tr>
  <tr>
    <td colspan="2" class="table_td1">
    
    	<? $paid_leads = get_clerk_paid_leads($current_clerk->vars["id"]); ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="table_header" align="center">Brand</td>
            <td class="table_header" align="center">Target URL</td>
            <td class="table_header" align="center">Keywords</td>
            <td class="table_header" align="center">Rank</td>
            <td class="table_header" align="center">Amount</td>
            <td class="table_header" align="center">Email</td>
            <td class="table_header" align="center">Method</td>
            <td class="table_header" align="center">Paid Date</td>
            <td class="table_header" align="center">Article</td>
            <td class="table_header" align="center"></td>
            <td class="table_header" align="center">Article URL</td>
            <td class="table_header" align="center"></td>
          </tr>
          <? foreach($paid_leads as $group){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
          <tr>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["brand"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["url"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["keywords"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["rank"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["amount"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["email"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["method"]; ?></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;">
            <?
             if ( $group->vars["paid_date"] != "0000-00-00" ) { 
               echo date("Y-m-d", strtotime($group->vars["paid_date"]));
             }
            ?>    
            </td> 
            
            <td class="table_td<? echo $style_color ?><? echo $style ?>">
                <? if($group->vars["article"] != ""){ ?> <a href="csv/<? echo $group->vars["article"] ?>" target="_blank">View</a> <? } ?>
            </td> 
            
            <td class="table_td<? echo $style_color ?><? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["paid_comments"]; ?></td>
            
            <td class="table_td<? echo $style_color ?><? echo $style ?>"><input name="aurl_<? echo $group->vars["id"] ?>" type="text" id="aurl_<? echo $group->vars["id"] ?>" /></td>
            <td class="table_td<? echo $style_color ?><? echo $style ?>">
                <input name="" type="button" value="Ready" class="red_btn" onClick="if(confirm('Are you sure you want to mark it as Ready?')){location.href = 'process/actions/seo_paid_ready.php?eid=<? echo $group->vars["id"] ?>&status=re&aurl='+encodeURIComponent(document.getElementById('aurl_<? echo $group->vars["id"] ?>').value);}" />
            </td> 
          </tr>
          
          <? } ?>
          <tr>
            <td class="table_last" colspan="100"></td>
          </tr>
        </table>
    
    </td>
    </tr>	
    
  <tr>
    <td class="table_header">Active Leads</td>
    <td class="table_header">Open Leads</td>
  </tr>
  <tr>
    <td class="table_td1">
    <?
	$active_leads = get_clerk_leads($current_clerk->vars["id"], "a"); 
	foreach($active_leads as $al){
		?>
        <p><a href="seo_lead_detail.php?l=<? echo $al->vars["id"] ?>" class="normal_link"><? echo $al->vars["website"] ?></a></p>
        <?
	}
	?>
    </td>
    <td class="table_td1">
    <?
	$open_leads = get_clerk_leads($current_clerk->vars["id"], "o"); 
	foreach($open_leads as $ol){
		?>
        <p><a href="seo_lead_detail.php?l=<? echo $ol->vars["id"] ?>" class="normal_link"><? echo $ol->vars["website"] ?></a></p>
        <?
	}
	?>
    </td>
  </tr>
  
</table>




</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>