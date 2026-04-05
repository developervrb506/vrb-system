<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php
 
  $leagues = get_all_event_leagues();
 
  
  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/book_order.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.reorder_link').on('click',function(){
		$("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
		$('.reorder_link').html('save reordering');
		$('.reorder_link').attr("id","save_reorder");
		$('#reorder-helper').slideDown('slow');
		$('.image_link').attr("href","javascript:void(0);");
		$('.image_link').css("cursor","move");
		$("#save_reorder").click(function( e ){
			if( !$("#save_reorder i").length )
			{
				$(this).html('').prepend('<img src="./images/refresh-animated.gif"/>');
				//$(this).removeClass('addmsg2');
				//$(this).html('<img src="images/refresh-animated.gif"/>');
				$("ul.reorder-photos-list").sortable('destroy');
				$("#reorder-helper").html( "Reordering Leagues - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
	
				var h = [];
				$("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id').substr(9));  });
				$.ajax({
					type: "POST",
					url: "league_order_update.php",
					data: {ids: " " + h + ""},
					success: function(html) 
					{
						
						window.location.reload();
						$("#reorder-helper").html( "Reorder Completed - Leagues reorder have been successfully completed. Please Go to Live Odds and check the new order." ).removeClass('light_box').addClass('notice notice_success');
						$('.reorder_link').html('reorder Leagues');
						$('.reorder_link').attr("id","");
					}
					
				});	
				return false;
			}	
			e.preventDefault();		
		});
	});
	
});
</script>
</head>

<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"> Leagues Order <? echo $league ?></span><br /><br />
<div align="right"><span ><a href="http://localhost:8080/ck/widget_manager/events_leagues.php">Back</a></span></div>


<div style="margin-top:20px;">
	 <a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Reorder Leagues</a> 
     
    <div id="reorder-helper" class="light_box" style="display:none;">1. Drag the League to reorder.<br>2. Click 'Save Reordering' when finished.</div>
    <div class="gallery">
        <ul class="reorder_ul reorder-photos-list">
        
        <?php 
			//Fetch all images from database
		    $k = 1;
			foreach($leagues as $row){ ?>
            <? $img_name = str_replace(" ","",$row->vars["league"]); ?> 
            <li style="width:250px" id="image_li_<? echo $row->vars['id']; ?>" class="ui-sortable-handle"><a href="javascript:void(0);" style="float:none;" class="image_link"><img width="180px" height="30px" src="./images/<? echo trim($img_name) ?>.jpg" alt="" /></a></li>
            
        <? $k++; } ?>
        </ul>
    </div>
</div>

</div>
<? include "../../includes/footer.php" ?>
