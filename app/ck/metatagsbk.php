<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("system_metatags")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Metatags</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript">

<? if($_GET["a"] == "a"){ ?>
alert("Record Added");
<? } ?>
<? if($_GET["a"] == "d"){ ?>
alert("Record Deleted");
<? } ?>
<? if($_GET["a"] == "u"){ ?>
alert("Record Updated"); 
<? } ?>
<!--
function delete_metatag(ID) {
	var answer = confirm("Are you sure that you want to delete this metatag?");
	if (answer){		
	   window.location = "process/actions/metatags.php?id="+ID;
	}	
}
//-->
function change_page(value){
	document.location.href = "" + value;
}

</script>
<script type="text/javascript">
  validations = new Array();
  validations.push({id:"url",type:"null", msg:"Please provide a url"});  
</script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
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
$metatag_id = $_GET["edit_id"];
$title_form = "Edit Metatag";
?>

<? if(isset($metatag_id)){ ?>
    <? 
	$metatag = get_metatag($metatag_id); 
	?>   
    <br /><span class="page_title"><? echo $title_form ?></span><br />
    <form action="process/actions/metatags.php" method="post" onSubmit="return validate(validations);">
	<table width="900" border="0" cellspacing="0" cellpadding="0" style="padding:10px;">    
      <tr>
        <? if(isset($metatag_id)){ ?>
        <input name="metatag_id" type="hidden" value="<? echo $metatag->vars["id"]; ?>">
        <input name="update" type="hidden" id="update" value="Y">        
        <? } else { ?>
        <input name="save" type="hidden" id="update" value="Y">
        <? } ?>  
        <td style="padding:10px;">Url:</td>
        <td style="padding:10px;">
          <input name="url" type="text" id="url" value="<? echo $metatag->vars["url"]; ?>" size="100">
        </td>
      </tr>      
      <tr>       
        <td style="padding:10px;">Meta title:</td>
        <td style="padding:10px;">
          <input name="title" type="text" id="title" value="<? echo $metatag->vars["title"]; ?>" size="100">
        </td>
      </tr>
      <tr>       
        <td style="padding:10px;">Meta Keywords:</td>
        <td style="padding:10px;">
          <input name="keywords" type="text" id="keywords" value="<? echo $metatag->vars["keywords"]; ?>" size="100">
        </td>
      </tr>
      <tr>
        <td style="padding:10px;">Meta Description:</td>
        <td style="padding:10px;"><textarea name="description" cols="90" rows="5" id="description"><? echo $metatag->vars["description"]; ?></textarea></td>
      </tr> 
      <tr>       
        <td style="padding:10px;">H1:</td>
        <td style="padding:10px;">
          <input name="h1" type="text" id="h1" value="<? echo $metatag->vars["h1"]; ?>" size="100">
        </td>
      </tr>
      <tr>
        <td style="padding:10px;">Body Text:</td>
        <td style="padding:10px;"><textarea name="body_text" cols="90" rows="20" id="body_text"><? echo $metatag->vars["body_text"]; ?></textarea></td>
      </tr>                    
      <tr>
        <td style="padding:10px;"></td>
        <td style="padding:10px;">
        <input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>    
  </form>

    
<? }else{$title_form = "Add Metatag"; ?>

<span class="page_title"><? echo $title_form ?></span>

<form action="process/actions/metatags.php" method="post" onSubmit="return validate(validations);">
	<table width="900" border="0" cellspacing="0" cellpadding="0" style="padding:10px;">    
      <tr>
        <? if(isset($metatag_id)){ ?>
        <input name="metatag_id" type="hidden" value="<? echo $metatag->vars["id"]; ?>">
        <input name="update" type="hidden" id="update" value="Y">        
        <? } else { ?>
        <input name="save" type="hidden" id="update" value="Y">
        <? } ?>  
        <td style="padding:10px;">Url:</td>
        <td style="padding:10px;">
          <input name="url" type="text" id="url" value="<? echo $metatag->vars["url"]; ?>" size="100">
        </td>
      </tr>      
      <tr>       
        <td style="padding:10px;">Meta title:</td>
        <td style="padding:10px;">
          <input name="title" type="text" id="title" value="<? echo $metatag->vars["title"]; ?>" size="100">
        </td>
      </tr>
      <tr>       
        <td style="padding:10px;">Meta Keywords:</td>
        <td style="padding:10px;">
          <input name="keywords" type="text" id="keywords" value="<? echo $metatag->vars["keywords"]; ?>" size="100">
        </td>
      </tr>
      <tr>
        <td style="padding:10px;">Meta Description:</td>
        <td style="padding:10px;"><textarea name="description" cols="90" rows="5" id="description"><? echo $metatag->vars["description"]; ?></textarea></td>
      </tr> 
      <tr>       
        <td style="padding:10px;">H1:</td>
        <td style="padding:10px;">
          <input name="h1" type="text" id="h1" value="<? echo $metatag->vars["h1"]; ?>" size="100">
        </td>
      </tr>
      <tr>
        <td style="padding:10px;">Body Text:</td>
        <td style="padding:10px;"><textarea name="body_text" cols="90" rows="20" id="body_text"><? echo $metatag->vars["body_text"]; ?></textarea></td>
      </tr>                    
      <tr>
        <td style="padding:10px;"></td>
        <td style="padding:10px;">
        <input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>    
  </form>

<br><br>
  <table style="cursor:pointer;" class="sortable">
    <thead>
        <tr>           
            <th class="table_header" scope="col" style="text-align: left">ID</th>
            <th class="table_header" scope="col" style="text-align: left">URL</th>          
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Edit</th>
            <th class="table_header" scope="col" style="text-align: center" class="sorttable_nosort">Delete</th>            
        </tr>
    </thead>
    <tbody id="the-list">
    <?
	$metatags = get_all_metatags();
	foreach($metatags as $metatag){
	 if($i % 2){$style = "1";}else{$style = "2";} $i++;
	?>          
        <tr>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: left"><? echo $metatag->vars["id"]; ?></th> 
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: left"><? echo $metatag->vars["url"]; ?></th>                 
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="change_page('metatags.php?edit_id=<? echo $metatag->vars["id"] ?>')" type="button" name="Button" value="View" /></th>
          <th class="table_td<? echo $style ?>" valign="top" style="text-align: center"><input onClick="delete_metatag('<? echo $metatag->vars["id"] ?>')" type="button" name="Button" value="Delete" /></th> 
        </tr>  
    <? } ?>  
           <tr>
			  <th class="table_last" colspan="100"></th>
			</tr>
    </tbody>
    </table>
 <? } ?>	
</div>
<? include "../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>