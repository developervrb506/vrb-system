<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<?
if($_POST){
	$path = "../images/affiliates/trainer_banners/";
	$filename = upload_image_partners("logo_file", $path, md5(rand()));
	if($filename != ""){$logo_url = BASE_URL . "/images/affiliates/trainer_banners/" . $filename;}
	$banner_id = $_POST["banners_list"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Casino Trainer</title>
</head>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $size = "93x25"; ?>
<? $campaigns = get_all_campaignes_for_affiliate($current_affiliate); ?>
<div class="page_content" style="padding-left:20px;">

<span class="page_title">Casino Trainer</span><br /><br /><br />

<div class="conte_banners" style="font-size:12px;">
            <div class="conte_banners_header"><strong>Black Jack Trainer</strong> </div>
        <br />
      <form method="post" action="trainer.php" enctype="multipart/form-data">
      <strong>Logo URL (270x51):&nbsp;&nbsp;</strong> <input name="logo_file" type="file" id="logo_file" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="logo_url" type="hidden" id="logo_url" value="<? echo $logo_url ?>"/>
      <input name="banners" type="hidden" id="banners" value="<? echo $banner_id ?>"/>
      <strong>Campaign:</strong> <? echo get_campaigns_by_size($campaigns, $size, "banners_list", "", false) ?>&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="" type="submit" value="Generate Code" /></form><br /><br />
      <br /><br />
      <div id="result" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div id="iframe_content"></div></td>
              <td valign="top"><strong>Code: </strong><br />
              <textarea name="code_text" cols="50" rows="4" readonly="readonly" id="code_text"></textarea><br />
              <input type="button" onClick="select_value('code_text');" value="Select Code" />
              </td>
            </tr>
          </table>
      </div>
      
    </div>

</div>
<? include "../includes/footer.php" ?>
<?
if($_POST){
	?><script type="text/javascript">blackjack_trainer_code('<? echo $current_affiliate->id ?>');</script><? 
}
?>