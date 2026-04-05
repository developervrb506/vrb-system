<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
<title>SEO Rankings</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? include "seo_menu.php" ?>
<span class="page_title">SEO Rankings</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="seo_new_ranking.php" class="normal_link">New Ranking</a>

<br /><br />
<? 
$brands = get_all_seo_brands();
$cbrand = clean_get("brand",true);
?>
<form method="get">
Brand: <? create_objects_list("brand", "brand", $brands, "id", "name", "All", $cbrand) ?>
<input name="" type="submit" value="Filter" />
</form>


<br /><br />

<?
$lists = get_all_seo_rankings($cbrand);
?>
<script type="text/javascript">
function update_thumb_field(id, field ){
	if(document.getElementById(field+"_"+id).className == "thumbs_down"){styler = "thumbs_up"; value = 1;}else{styler = "thumbs_down"; value = 0;}
	document.getElementById('iloader').src = "process/actions/seo_update_ranking_thumbs.php?uid="+id+"&field="+field+"&value="+value;	
	document.getElementById(field+"_"+id).className = styler;
}

function counter_int(type,id){
	
	var value = document.getElementById("int_links_"+id).value;
		
	if (type == 1){
	   value = parseInt(value)+1;
	}
	else{
	   value = parseInt(value)-1;
	}
	
	if (value >= 0){ 
		document.getElementById("int_links_"+id).value = value;	
	}
}

function counter_google(type,id){
	
	var value = document.getElementById("google_"+id).value;
		
	if (type == 1){
	   value = parseInt(value)+1;
	}
	else{
	   value = parseInt(value)-1;
	}
	
	
		document.getElementById("google_"+id).value = value;	
	
}
function update_all(){
	if(confirm("Are you sure you want to UPDATE all the records?")){
		$("#contentpath").hide();
		$("#loadingpath").show();
		$(".uids").each(function(index) {
			var currentid = $(this).val();
			$("#internal_"+currentid).val("1");
			$("#frm_"+currentid).attr("target","saver_"+currentid);
			$("#frm_"+currentid).submit();
		});
		setTimeout("reload_page()",30000);
	}
}
function reload_page(){
	location.href = location.href;	
}
</script>


<iframe name="iloader" id="iloader" width="1" height="1" scrolling="no" frameborder="0"></iframe>

<div id="loadingpath" align="center" style="display:none;">
	<h1>Updating records....</h1>
    <p>This may take several seconds to complete.</p>
</div>
<div id="contentpath">
    <p><input type="button" value="Update All" onclick="update_all()" /></p>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header">Brand</td>
        <td class="table_header">URL</td>
        <td class="table_header">Keyword</td>
        <td class="table_header">Paid Links</td>
         <td class="table_header">Intern al Links</td>
        <td class="table_header">Google</td>
        <td class="table_header" style="display:none">G. Previous</td>
        <td class="table_header">G. Change</td>
        <td class="table_header"># Searches</td>
        <?php /*?><td class="table_header">Yahoo</td>
        <td class="table_header">Y. Previous</td>
        <td class="table_header">Y. Change</td><?php */?>
        
        <td class="table_header">On Site</td>
        <td class="table_header" style="display:none">Mobile</td>
        <td class="table_header">% Start</td>
        <td class="table_header">% Now</td>
        <td class="table_header">Content</td>
        
        <td class="table_header"></td>
        <td class="table_header">Edit</td>
      </tr>
      <? $total_links = 0; ?>
      <? foreach($lists as $list){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
      <? $paids = seo_cound_paid_links($brands[$list->vars["brand"]]->vars["name"], $list->vars["keyword"]) ?>
      <iframe name="saver_<? echo $list->vars["id"] ?>" id="saver_<? echo $list->vars["id"] ?>" width="1" height="1" scrolling="no" frameborder="0"></iframe>
      <form method="post" action="process/actions/seo_update_ranking.php" id="frm_<? echo $list->vars["id"] ?>">
      
      <input name="update_id" class="uids" type="hidden" id="update_id" value="<? echo $list->vars["id"] ?>" />
      
      <input name="internal" type="hidden" id="internal_<? echo $list->vars["id"] ?>" value="0" />
      
      <tr>
        <td class="table_td<? echo $style ?>"><? echo $brands[$list->vars["brand"]]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $list->vars["url"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $list->vars["keyword"]; ?></td>
        <td class="table_td<? echo $style ?>">
            <a href="seo_system.php?paid=1&brand=<? echo $brands[$list->vars["brand"]]->vars["name"] ?>&keyword=<? echo $list->vars["keyword"] ?>" class="normal_link" target="_blank">
                <? echo $paids["total"]; $total_links += $paids["total"]; ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>">
            <a style="font-size:16px" class="normal_link" href="javascript:counter_int(0,'<? echo $list->vars["id"] ?>')">-</a>
            <input name="int_links" type="text" id="int_links_<? echo $list->vars["id"] ?>" value="<? echo $list->vars["int_links"] ?>" size="4" style="width:30px" readonly="readonly" />
        	<a class="normal_link" href="javascript:counter_int(1,'<? echo $list->vars["id"] ?>')">+</a>
        </td>
        <td class="table_td<? echo $style ?>">
            <a style="font-size:16px" class="normal_link" href="javascript:counter_google(0,'<? echo $list->vars["id"] ?>')">-</a>
            <input readonly="readonly" name="google" type="text" id="google_<? echo $list->vars["id"] ?>" value="<? echo $list->vars["google"] ?>" size="4" style="width:30px" />
             <a class="normal_link" href="javascript:counter_google(1,'<? echo $list->vars["id"] ?>')">+</a>
         </td>
        
        <td style="display:none" class="table_td<? echo $style ?>"><input name="google_previous" type="text" id="google_previous" value="<? echo $list->vars["google_previous"] ?>" size="4" /></td>
        <td class="table_td<? echo $style ?>"><? echo $list->vars["google_change"] ?></td>
        
        <td class="table_td<? echo $style ?>">
        <input name="searches" type="text" id="searches<? echo $list->vars["id"] ?>" value="<? echo $list->vars["searches"] ?>" size="4" style="width:30px" />
        </td>
        
        <?php /*?><td class="table_td<? echo $style ?>"><input name="yahoo" type="text" id="yahoo" value="<? echo $list->vars["yahoo"] ?>" size="4" /></td>
        <td class="table_td<? echo $style ?>"><input name="yahoo_previous" type="text" id="yahoo_previous" value="<? echo $list->vars["yahoo_previous"] ?>" size="4" /></td>
        <td class="table_td<? echo $style ?>"><input name="yahoo_change" type="text" id="yahoo_change" value="<? echo $list->vars["yahoo_change"] ?>" size="4" /></td><?php */?>
        
        <td class="table_td<? echo $style ?>" align="center">
            <? 
            if($list->vars["onsite"]){$btn = "thumbs_up";}else{$btn = "thumbs_down";}
            ?>
            <input name="onsite_<? echo $list->vars["id"]; ?>" type="button" class="<? echo $btn ?>" id="onsite_<? echo $list->vars["id"]; ?>" onclick="update_thumb_field('<?  echo $list->vars["id"]; ?>','onsite');"  />
        </td>
        <td class="table_td<? echo $style ?>" align="center" style="display:none">
            <? 
            if($list->vars["mobile"]){$btn = "thumbs_up";}else{$btn = "thumbs_down";}
            ?>
            <input name="mobile_<? echo $list->vars["id"]; ?>" type="button" class="<? echo $btn ?>" id="mobile_<? echo $list->vars["id"]; ?>" onclick="update_thumb_field('<?  echo $list->vars["id"]; ?>','mobile');"  />
        </td>
        
        
        <td class="table_td<? echo $style ?>">
        <input name="per_start" type="text" id="per_start<? echo $list->vars["id"] ?>" value="<? echo $list->vars["per_start"] ?>" size="4" style="width:30px" />
        </td>
        
        <td class="table_td<? echo $style ?>">
        <input name="per_now" type="text" id="per_now<? echo $list->vars["id"] ?>" value="<? echo $list->vars["per_now"] ?>" size="4" style="width:30px" />
        </td>
        
        <td class="table_td<? echo $style ?>" align="center">
            <? 
            if($list->vars["content"]){$btn = "thumbs_up";}else{$btn = "thumbs_down";}
            ?>
            <input name="content_<? echo $list->vars["id"]; ?>" type="button" class="<? echo $btn ?>" id="content_<? echo $list->vars["id"]; ?>" onclick="update_thumb_field('<?  echo $list->vars["id"]; ?>','content');"  />
        </td>
        
        <td class="table_td<? echo $style ?>"><input name="" type="submit" value="Update" /></td>
        <td class="table_td<? echo $style ?>"><a href="seo_new_ranking.php?lid=<? echo $list->vars["id"]; ?>" class="normal_link">Edit</a></td>
      </tr>
      </form>
      <? } ?>
      <tr>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"><? echo $total_links ?></td>
         <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header" style="display:none"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header" style="display:none"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
        <td class="table_header"></td>
      </tr>
      
    </table>
    
    <p><input type="button" value="Update All" onclick="update_all()" /></p>

</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>