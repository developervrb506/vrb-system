<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_descriptions")){ ?>
<?
if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upid = get_affiliate_description($_POST["update_id"]);
		$upid->vars["affiliate"] = $_POST["affiliate"];
		$upid->vars["description"] = $_POST["description"];
		$upid->vars["code"] = $_POST["code"];
		$upid->vars["title"] = $_POST["title"];
		$image = upload_file("aflogo", "images/affiliates/", mt_rand());
		if($image!=""){$upid->vars["image"] = $image;}
		$upid->update();
	}else{
		$exaff = get_affiliate_description_by_af($_POST["affiliate"]);
		if(is_null($exaff)){
			$newid = new _affiliate_description();
			$newid->vars["affiliate"] = $_POST["affiliate"];
			$newid->vars["description"] = $_POST["description"];
			$newid->vars["title"] = $_POST["title"];
			$newid->vars["code"] = $_POST["code"];
			$newid->vars["image"] = upload_file("aflogo", "images/affiliates/", mt_rand());
			$newid->insert();
		}else{
			$exaff->vars["affiliate"] = $_POST["affiliate"];
			$exaff->vars["description"] = $_POST["description"];
			$exaff->vars["title"] = $_POST["title"];
			$exaff->vars["code"] = $_POST["code"];
			$image = upload_file("aflogo", "images/affiliates/", mt_rand());
			if($image!=""){$exaff->vars["image"] = $image;}
			$exaff->update();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliates Comments</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	$description = get_affiliate_description($_GET["idf"]);
	if(is_null($description)){
		$title = "Add new Comment";
	}else{
		$title = "Edit Comment";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$description->vars["id"] .'" />';
		$read = 'readonly="readonly"';
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"affiliate",type:"null", msg:"Name is required"});
	validations.push({id:"description",type:"null", msg:"Comment is required"});
    </script>
	<div class="form_box" style="width:400px;">
        <form method="post" action="affiliates_description.php?e=52" onsubmit="return validate(validations)" enctype="multipart/form-data">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Affiliate</td>
            <td><input name="affiliate" type="text" id="affiliate" value="<? echo $description->vars["affiliate"] ?>" <? echo $read ?>/></td>
          </tr> 
          <tr>
            <td>Title</td>
            <td><input name="title" type="text" id="title" value="<? echo $description->vars["title"] ?>"/></td>
          </tr> 
          <tr>
            <td>Image</td>
            <td>
            	<? if($description->vars["image"]!=""){ ?>
                <img src="http://vrbmarketing.com/ck/images/affiliates/<? echo $description->vars["image"] ?>" style="max-width:100px;" />
                <? } ?>
                <br /><input name="aflogo" type="file" id="aflogo" />
            </td>
          </tr> 
          <tr>
            <td>Comment</td>
            <td><textarea name="description" id="description"><? echo $description->vars["description"] ?></textarea></td>
          </tr>
          <tr>
            <td>Code</td>
            <td><input name="code" type="text" id="code" value="<? echo $description->vars["code"] ?>"/></td>
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
    <span class="page_title">Affiliates Comments</span><br /><br />
    <? if(!$current_clerk->im_allow("affiliate_descriptions_view")){ ?><a href="?detail" class="normal_link">+ Add Comment</a><br /><br /><? } ?>
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Affiliate</td>
        <td class="table_header" align="center">Title</td>
        <td class="table_header">Comment</td>
        <td class="table_header">Code</td>
        <td class="table_header" align="center">Edit</td>
      </tr>
      <?
	  $i=0;
	   $comments = get_all_get_affiliate_descriptions();
	   foreach($comments as $cm){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["affiliate"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $cm->vars["title"]; ?></td>
        <td class="table_td<? echo $style ?>" ><? echo $cm->vars["description"]; ?></td>
        <td class="table_td<? echo $style ?>" ><? echo $cm->vars["code"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<? if(!$current_clerk->im_allow("affiliate_descriptions_view")){ ?>
            <a href="?detail&idf=<? echo $cm->vars["id"]; ?>" class="normal_link">Edit</a>
            <? } ?>
        </td>
      </td>
      <? } ?>
      <tr>
        <td class="table_last"></td>
        <td class="table_last"></td>
        <td class="table_last"></td>
      </tr>
  
    </table>
      
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>