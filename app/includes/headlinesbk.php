<div class="wrapper_banner"> 
<? $headlines = get_all_headlines(); ?> 
<? if ( count($headlines) > 0 ) { ?> 
<div id="featured_border_headlines" class="jcarousel-container">
  <div id="featured_wrapper_headlines" class="jcarousel-clip">
    <ul id="featured_images_headlines" class="jcarousel-list">
    <?
    foreach($headlines as $headline){
		if ($headline->vars["link"] == "") {
			$link = "#";
		}
		else {
		  $link = $headline->vars["link"];   
		}	
	?>  
	<li> 
    <? if ($link != "#") { ?>       
      <a href="<? echo $link ?>" target="_blank"><img title="<? echo $headline->vars["alt_desc"] ?>" alt="<? echo $headline->vars["alt_desc"] ?>" src="<? echo $url_headlines_vrb.$headline->vars["image_name"] ?>" width="900" height="325" border="0" /></a>
    <? } else { ?>
      <img title="<? echo $headline->vars["alt_desc"] ?>" alt="<? echo $headline->vars["alt_desc"] ?>" src="<? echo $url_headlines_vrb.$headline->vars["image_name"] ?>" width="900" height="325" border="0" /> 
    <? } ?>        
    </li>      	 
    <? } ?>        
    </ul>
  </div> 
</div>
<? } ?>    
</div>