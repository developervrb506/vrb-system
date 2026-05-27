<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("new_features")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>New Feature Notes</title>

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>



<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/htmltinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
</script>
</head>
<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
// Page Logic
$edit = false;
if (isset($_GET["id"])){
 $edit = true;
 $feature_id =  $_GET["id"];
}



if ($edit){

  $feature = get_new_feature($feature_id );

  $metatag_id =  $posting->vars["post_metatag_id"];
  $brand =  $posting->vars["post_brand"];
  $cat = $posting->vars["post_category"];
  $league = $posting->vars["post_league"];
  $check = 1;	
  $title_form = "Edit Feature Note";	
}
else {
  $title_form = "Add New Feature Note";
}
 
?>

<span class="page_title"><? echo $title_form ?></span>
<div align="right"><span ><a href="new_feature.php">Back</a></span></div>
<BR><BR>





<?

?>
<form action="./process/actions/new_feature_action.php" method="post">
 <? if ($edit) {?>
   <input type="hidden" value="<? echo $feature_id ?>" name="id"  />
 <? } ?>
   <input type="hidden" value="newEdit" name="type"  />
  
	<table width="900" border="0" cellspacing="0" cellpadding="0" style="padding:10px;">    
      <tr>
        <td style="padding:10px;">Type:</td>
        <td style="padding:10px;">
          <select required name ="f_type" id="f_type"  >
          <option value="">Select a Type</option>
          <option <? if ($feature->vars["type"] == 'a') { echo ' selected="selected" '; }?> value="a">Agent</option>
          <option <? if ($feature->vars["type"] == 'p') { echo ' selected="selected" '; }?> value="p">Player</option>
          </select> 
        </td>
        </tr>  
        <tr>       
        <td style="padding:10px;">Status :</td>
        <td style="padding:10px;">
          <input type="checkbox" name="active" <? if ($feature->vars["active"] || (!$edit)){ echo ' checked="checked" ';}?> value="1" />
        </td>
      </tr>
      
      <tr>
        <td style="padding:10px;">Description:</td>
        <td style="padding:10px;"><textarea name="content" cols="90" rows="30" id="content"><? echo $feature->vars["description"]; ?></textarea></td>
      </tr>
       
      
                       
      <tr>
        <td style="padding:10px;"></td>
        <td style="padding:10px;">
        <input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>    
  </form>


</div>
<? include "../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>