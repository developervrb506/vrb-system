<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("posting")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Postings</title>
<link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"public_date",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>

<script type="text/javascript">
  validations = new Array();
  validations.push({id:"posting_type",type:"null", msg:"Please provide a Posting Type"});  
  validations.push({id:"posting_brand",type:"null", msg:"Please provide a  Brand"});  
  validations.push({id:"posting_league",type:"null", msg:"Please provide a League"});  
  validations.push({id:"public_date",type:"null", msg:"Please provide a Date"});    
  validations.push({id:"title",type:"null", msg:"Please provide a Title"}); 
  validations.push({id:"seo_title",type:"null", msg:"Please provide a SEO Title"}); 
  validations.push({id:"image",type:"null", msg:"Please provide a URL Image"});  
  validations.push({id:"content",type:"null", msg:"Please provide a Content"});      
</script>

<script type="text/javascript" src="http://localhost:8080/ck/includes/htmltinymce/tinymce.min.js"></script>
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

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<?
// Page Logic
$edit = false;
if (isset($_GET["post_id"])){
 $edit = true;
 $post_id =  $_GET["post_id"];
}


$check = 0;
if (isset($_POST["metatag"])){
  $metatag_id = $_POST["metatag"];
  $metatag = get_metatag($metatag_id);   
  if (!is_null($metatag)){
   $check = 1;	  	  
  } else { $check = 2;}
}

if ($edit){

  $posting = get_posting($post_id);

  $metatag_id =  $posting->vars["post_metatag_id"];
  $brand =  $posting->vars["post_brand"];
  $cat = $posting->vars["post_category"];
  $league = $posting->vars["post_league"];
  $check = 1;	
  $title_form = "Edit Posting";	
}
else {
  $title_form = "Add Posting";
}
 
?>

<span class="page_title"><? echo $title_form ?></span>
<div align="right"><span ><a href="posting_view.php">Back</a></span></div>
<BR><BR>
<? // TO check the metatag ID,  afther the Post is created the Metatag URL will be Updated ?>
<form method="post" action="http://localhost:8080/ck/posting/posting.php">
&nbsp;&nbsp;<a href="http://localhost:8080/ck/metatags.php" target="_blank" title="Click to Open Metatags Tool">Metatag ID</a> :
<input type="text" name="metatag" id="metatag" value="<? echo $metatag_id ?>" />
<input type="submit" value="check" /> &nbsp;&nbsp;
<? if ($check > 0 && $check == 1) { ?>
<img src="../../images/icons/complete_vrb.png"  />
<? } else if ($check > 0 && $check == 2 ) { ?>
<img src="../../images/icons/delete_vrb.png"  /> &nbsp;&nbsp; Please check the Rigth ID
<? } ?>
</form>



<? if ($check == 1) {  //IF THE METAG ID IS VALID  ?>

<?
$posting_type = get_posting_types();
$leagues = array("NFL","NHL","MLB","NBA","NCAAF","NCAAB","GOLF","TENNIS","MMA","BOXING");

?>
<form action="../process/actions/posting_action.php" method="post" onSubmit="return validate(validations);">
 <? if ($edit) {?>
   <input type="hidden" value="<? echo $post_id ?>" name="post_id"  />
 <? } ?>
 
  <input type="hidden" value="<? echo $metatag_id ?>" name="post_metatag">
	<table width="900" border="0" cellspacing="0" cellpadding="0" style="padding:10px;">    
      <tr>
        <td style="padding:10px;">Posting Type:</td>
        <td style="padding:10px;">
          <select name ="posting_type" id="posting_type"  >
          <option value="">Select a Type</option>
          <? foreach ($posting_type as $pt) {?>
            <option <? if ($posting->vars["post_type"] == $pt["id"]) { echo ' selected="selected" '; }?> value="<? echo $pt["id"]?>"><? echo $pt["description"]?></option>
          <? } ?>
          </select> <span style="font-size:11px; margin-top:5px"><strong>For BitBet, use only the Type SportsNews to be handled as News</strong></span>
        </td>
        </tr>  
        <tr>
        <td style="padding:10px;">Brand:</td>
        <td style="padding:10px;">
          <select name ="posting_brand" id="posting_brand"  >
          <option value="">Select a Type</option>
          <option <? if ($brand == 3 ) { echo ' selected="selected" '; }?> value="3">SBO</option>
          <option <? if ($brand == 6 ) { echo ' selected="selected" '; }?> value="6">PBJ</option>
          <option <? if ($brand == 7 ) { echo ' selected="selected" '; }?> value="7">OWI</option>  
          <option <? if ($brand == 9 ) { echo ' selected="selected" '; }?> value="9">HRB</option> 
          <option <? if ($brand == 8 ) { echo ' selected="selected" '; }?> value="8">BitBet</option>   
          <option <? if ($brand == 10 ) { echo ' selected="selected" '; }?> value="10">Bet Lion</option>  
          </select>                  
        </td>
         
      </tr>      
      <tr>
        <td style="padding:10px;">Category:</td>
        <td style="padding:10px;">
          <select name ="posting_category" id="posting_category"  >
          <option value="">Select a Type</option>
          <option <? if ($cat == 1 ) { echo ' selected="selected" '; }?> value="1">Sportbook</option>
          <option <? if ($cat == 2 ) { echo ' selected="selected" '; }?> value="2">Casino</option>
          <option <? if ($cat == 3 ) { echo ' selected="selected" '; }?> value="2">Horse Racing</option>
          
           </select>                  
        </td>
         
      </tr>  
      <tr>
        <td style="padding:10px;">League:</td>
        <td style="padding:10px;">
          <select name ="posting_league" id="posting_league"  >
          <option value="">Select a Type</option>
          <? foreach ($leagues as $lg) {?>
            <option <? if ($league == $lg ) { echo ' selected="selected" '; }?> value="<? echo $lg ?>"><? echo $lg ?></option>
          <? } ?>
          </select>
        </td>
        </tr> 
       
      <tr>       
        <td style="padding:10px;">Date :</td>
        <td style="padding:10px;">
          <input name="public_date" type="text" id="public_date" value="<? echo $posting->vars["post_date"]; ?>" />
        </td>
      </tr>
      <tr>       
        <td style="padding:10px;">Publish :</td>
        <td style="padding:10px;">
          <input type="checkbox" name="publish" <? if ($posting->vars["post_status"]){ echo ' checked="checked" ';}?> value="1" />
        </td>
      </tr>
      <tr>       
        <td style="padding:10px;">Title:</td>
        <td style="padding:10px;">
          <input name="title" type="text" id="title" value="<? echo $posting->vars["post_title"]; ?>" size="100">
        </td>
      </tr>
      <tr>       
        <td style="padding:10px;">Sub title:</td>
        <td style="padding:10px;">
          <input name="sub_title" type="text" id="sub_title" value="<? echo $posting->vars["post_sub_title"]; ?>" size="100">
        </td>
      </tr>
       <tr>       
        <td style="padding:10px;">SEO title:</td>
        <td style="padding:10px;">
          <input name="seo_title" type="text" id="seo_title" value="<? echo $posting->vars["post_seo_title"]; ?>" size="100">
        </td>
      </tr>
     
       <tr>       
        <td style="padding:10px;">Image (url): </td>
        <td style="padding:10px;">
          <input name="image" type="text" id="image" value="<? echo $posting->vars["post_image"]; ?>" size="90">
        
        </td>
      </tr>
       <tr>       
        <td style="padding:10px;">Alt: </td>
        <td style="padding:10px;">
           <input name="image_alt" type="text" id="image_alt" value="<? echo $posting->vars["post_image_alt"]; ?>" size="90">
        </td>
      </tr>
      <? if ($edit) { ?>
         <tr>       
        <td style="padding:10px;">URL: </td>
        <td style="padding:10px;">
           <input  readonly="readonly" name="slug_url" type="text" id="slug_url" value="<? echo $posting->vars["post_slug"]; ?>" size="125">
        </td>
      </tr>
      <? } ?>
      
      
      <tr>
        <td style="padding:10px;">Content:</td>
        <td style="padding:10px;"><textarea name="content" cols="90" rows="50" id="content"><? echo $posting->vars["post_content"]; ?></textarea></td>
      </tr>
       
      
                       
      <tr>
        <td style="padding:10px;"></td>
        <td style="padding:10px;">
        <input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>    
  </form>
<? } ?>

</div>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>