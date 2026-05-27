<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<? $message = get_ck_message($_GET["mid"]); ?>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"content",type:"null", msg:"Content is required"});
function mark_all(id){
	table = document.getElementById("g_"+id);
	selector = document.getElementById("all_sel_"+id);
	mark = true;
	if(selector.checked == false){mark = false;}
	items = table.getElementsByTagName("input");
	for(var i = 0; i<items.length; i++){
		if(items[i].type == "checkbox"){
			items[i].checked = mark ;
		}
	}
}
function change_receiver(){
	display_div('people');
	window.scrollTo(0,200);
	document.getElementById("rec").value = "1";
}
</script>
<style type="text/css">
body {
	background-color: #FFF;
}
</style>

<div style="padding:10px;">

<form method="post" action="../process/actions/edit_message_action.php" target="_parent" onsubmit="return validate(validations);">
	<input name="edit" type="hidden" id="edit" value="<? echo $message->vars["id"] ?>" />
    <input name="rec" type="hidden" id="rec" value="0" />
	<textarea name="content" rows="12" style="width:98%" id="content"><? echo $message->vars["content"] ?></textarea>
    
    <a name="rec" id="rec"></a>
    <br />
    <a href="javascript:;" class="normal_link" style="font-size:12px;" onclick="change_receiver();">Change Receivers</a>
    <br />    
    <div style="display:none" id="people">
    	<? $groups = get_all_user_groups(); ?>
    	<? foreach($groups as $group) {?>
        
			<? $clerks = get_all_clerks_by_group($group->vars["id"]) ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;" id="g_<? echo $group->vars["id"] ?>">
              <tr>
                <td class="table_header" align="center" width="250"><? echo $group->vars["name"] ?></td>
                <td class="table_header" align="center">
                	Select <input type="checkbox" id="all_sel_<? echo $group->vars["id"] ?>" onclick="mark_all('<? echo $group->vars["id"] ?>');" value="" />
                </td>
              </tr>
              <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
              <tr>
                <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
                <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
                    <input name="clerk_<? echo $clerk->vars["id"]; ?>" type="checkbox" id="clerk_<? echo $clerk->vars["id"]; ?>" <? if($message->vars["to"]->vars["id"] == $clerk->vars["id"]){echo 'checked="checked"';} ?> value="1" />
                </td>
              </tr>
              <? } ?>
              <tr>
                <td class="table_last"></td>
                <td class="table_last"></td>
              </tr>
            </table>
        
        <? } ?>
    </div>
    <input name="" type="submit" value="Submit" />
</form>
</div>