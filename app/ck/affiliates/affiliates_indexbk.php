<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>AFFILIATES</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">AFFILIATES</span><br /><br />

<? include "../includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">
  
    
<? if($current_clerk->im_allow("affiliate_descriptions")){ ?>             
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates_description.php">AF Comments</a><br />
        Manage the option to create Comments to the Affiliates
    </td>
  </tr>
 <? } ?>
 <? if($current_clerk->im_allow("agent_freeplays")){ ?>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/agent_freeplays.php">AF Freelays</a><br />
        Manage the option create te FreePlays to Agents
    </td>
  </tr>
 <? } ?> 
 <? if($current_clerk->im_allow("affiliate_leads")){ ?>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates_leads.php">AF Leads</a><br />
        Manage the option to handle the Affiliates leads
    </td>
  </tr>
   <? } ?> 
  
   <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_approve.php">Approve Partners</a><br />
        Approve or Decline Pending Affiliates
    </td>
  </tr>
   <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/endorsements_default.php">Default Endorsements</a><br />
        Create and Edit Default Endorsements
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_campaignes.php">Manage Campaigns </a><br />
        Manage and customize campaigns
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_campaignes.php">Manage Casino Games</a><br />
        Access to Manage Casino Games Links
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_affiliates.php">Manage Partners</a><br />
        Manage the Affiliate Partners
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_text_link_view.php">Manage Text Links</a><br />
        Manage the text links
    </td>
  </tr>
   <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_custom_promotype_view.php">Manage Custom Promotion types</a><br />
        Manage and customize promotions
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_news.php">News & Updates</a><br />
        Add and edit News and Updates 
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_search_ids.php">Search by Id</a><br />
        Affiliate search by ID
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/partners_testimonials.php">Testimonials</a><br />
        Manage and Add Testimonials
    </td>
  </tr>
  <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/20games.php">Special Trends</a><br />
        Manage the option to pick the best trends for game
    </td>
  </tr>
    <tr>
      <td width="50%">
        <a class="normal_link" href="http://localhost:8080/ck/affiliates/contest.php">Insider Contests</a><br />
        Manage the option to handle the Insider Constests
    </td>
  </tr>
  
 
</table>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>