<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Events leagues</title>
<script type="text/javascript" src="/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="/process/js/jquery.js"> </script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Leagues Manager</span>
<br /><br />
<div id="success_saved"></div>
<br /><br />
<?
$leagues = get_leagues(1);
$cant_leagues = count($leagues);

if(!is_null($leagues)) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>    
    <td class="table_header" align="center"><strong>League</strong></th>
    <td class="table_header" align="center"><strong>Sort</strong></th>
    <td class="table_header" align="center"><strong>Active</strong></th>
    <td class="table_header" align="center"><strong>Default</strong></th>     
    <td class="table_header" align="center"><strong>Default Line Type</strong></th>
  </tr>

   <?   
   foreach( $leagues as $row ){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   ?>
  <tr id="tr_<? echo $row->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $row->vars["league"]; ?></th>
        <th class="table_td<? echo $style ?>">		        
         <select class="position" name="position_<? echo $row->vars["pos"] ?>" id="position_<? echo $row->vars["id"] ?>" style="width:50px;">
            <? for ($j = 1; $j <= $cant_leagues; $j++){ ?>
            <option <? if ($j == $row->vars["pos"]){ echo "selected"; } ?>  value="<? echo $j; ?>"><? echo $j; ?></option>
    <? } ?>
         </select>                  
         </th>
         <th class="table_td<? echo $style ?>">		        
         <input class="available" name="available_<? echo $row->vars["pos"] ?>" id="available_<? echo $row->vars["id"] ?>" type="checkbox" <? if ($row->vars["available"] == 1){ ?>checked="checked" <? } ?> />                
         </th>
         <th class="table_td<? echo $style ?>">		        
         <input class="available" name="available_<? echo $row->vars["pos"] ?>" id="available_<? echo $row->vars["id"] ?>" type="checkbox" <? if ($row->vars["available"] == 1){ ?>checked="checked" <? } ?> />                
         </th>
         <th class="table_td<? echo $style ?>">		        
         <select class="default_line_type" name="default_line_type_<? echo $row->vars["pos"] ?>" id="default_line_type_<? echo $row->vars["id"] ?>" style="width:90px;"> 
            <option <? if ("" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="">Choose</option>
            <option <? if ("s" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="s">Spread</option>
            <option <? if ("m" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="m">Moneyline</option>
            <option <? if ("t" == $row->vars["default_line_type"]){ echo "selected"; } ?>  value="t">Total</option>
         </select>                
         </th>
        
  </tr>
<? } ?>
 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>      
  </tr>
</table>
 
<BR>
<? } else {

    $html= 'No Data Found';
	echo $html;
} 
?>
</div>
<? include "../../includes/footer.php" ?>

<script>	

$(document).on("change", ".position, .available, .default_line_type", function(e){
        		
		e.preventDefault();
		var id, position_select_list, position_select_list2, position, default_line_type;
		
		position_select_list = $(this);
		id = position_select_list.attr("id");		
		id = id.split('_');
	    id = id[1];
										
		position = $("#position_"+id).val();
									
		if($("#available_"+id).is(':checked')){
			available = 1;			
			$("#available_"+id).prop("checked", true);
		}else{
			available = 0;			
			$("#available_"+id).attr("checked", false);
		}
		
		position_select_list2 = $(this);
		id = position_select_list2.attr("id");		
		id = id.split('_');
	    id = id[3];
		
		default_line_type = $("#default_line_type_"+id).val();
													
		
        $.ajax({
            type: "POST",
            url: "/ck/process/actions/update_leagues_order_control.php",
            data: "id="+id+"&position="+position+"&available="+available+"&default_line_type="+default_line_type+"&type=1",
            success: function(data) {	    
				 $('#success_saved').html('The information has been saved successfully.');
				 $('#success_saved').fadeIn(2000);
				 $('#success_saved').fadeOut(2000);
            },
            error: function(err){                
				$('#success_saved').html(err);
				$('#success_saved').fadeIn(2000);
				$('#success_saved').fadeOut(2000);
            }
        });	
		
});	
</script>