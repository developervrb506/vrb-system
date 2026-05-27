<div class="menu" id="menudiv">
    <div id="menu_header">
        <ul class="nav">
             <? 
             function print_menu($level){
                $items = get_menu($level);
                foreach($items as $item){
                    ?> 
                    <li>
                        <a href="<? echo $item ->vars["link"] ?>"><? echo $item ->vars["name"] ?></a>
                        <?php /*?>Add this code to make it dropdown menu<?php */?>
						<?php /*?><? if($item ->vars["is_category"]){ ?>
                        <ul> <? print_menu($item ->vars["id"]) ?> </ul>
                        <? } ?><?php */?>
                    </li>
                    <?	
                }	 
             }
             print_menu(0);
             ?>
             
             <li> <a href="javascript:;">|<input type="text" placeholder=" Type to search on menu" id="param_menu" onkeyup="search_menu();" />|</a> <ul class="nav"><li id="menu_search_res"></li></ul> </li>
             
             <li> <a href="<?= BASE_URL ?>/ck/page_menu.php?c=del">DELETED</a> </li>
             
             <li> <a href="<?= BASE_URL ?>/process/login/logout.php">Logout</a> </li>
             
        </ul>     
    
    </div>
</div>

<script type="text/javascript">

function search_menu(){
	var param = $("#param_menu").val();
	$("#menu_search_res").html("<li><a href='javascript:;'>Searching...</a></li>");	
	$.get(BASE_URL . "/ck/process/actions/menu_search.php?param="+param, function( data ) {
	  if(data != ""){
		  $("#menu_search_res").html(data);	
	  }else{
			$("#menu_search_res").html("<li><a href='javascript:;'>Nothing found</a></li>");	  
	  }
	});
}

function submenu_action(box, on, setpos){
	var boxdiv = document.getElementById("sub"+box)
	var menudiv = document.getElementById("menudiv");
	var menusize = menudiv.parentNode.style.width;
	if(menusize == "100%"){menusize = browser_width();}else{menusize = 970;}
	if(setpos){
		boxdiv.style.marginLeft = (window.event.clientX - ((browser_width() - menusize)/2) - 40)+"px";
	}
	if(on){sdis = "block";}
	else{sdis = "none";}
	boxdiv.style.display = sdis;
}
function browser_width(){
	if(window.innerHeight !==undefined)A= window.innerWidth; // most browsers
	else{ // IE varieties
	var D= (document.body.clientWidth)? document.body: document.documentElement;
	A= D.clientWidth;	
	}
	return A;
}
</script>
