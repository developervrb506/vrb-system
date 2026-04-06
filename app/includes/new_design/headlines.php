<div class="main_headline">

<div id="h1"><a href="<?= BASE_URL ?>/consulting.php"><img src="<?= BASE_URL ?>/images/new_design/900x344_branding.jpg" width="900" height="344" alt="Branding" border="0" /></a></div>
<div id="h2" style="display:none;"><a href="<?= BASE_URL ?>/email-marketing.php"><img src="<?= BASE_URL ?>/images/new_design/900x344_conversions.jpg" width="900" height="344" alt="Conversions" border="0" /></a></div>
<div id="h3" style="display:none;"><a href="<?= BASE_URL ?>/seo.php"><img src="<?= BASE_URL ?>/images/new_design/900x344_seo.jpg" width="900" height="344" alt="SEO" border="0" /></a></div>
</div>
<script type="text/javascript">
var cant    = 3;
var current = 1;
setInterval("rotate_headline('R')",7000);
function rotate_headline(side){

   if (side == 'R') {
	   
	   next = current + 1; 
	   
	   if (next > cant) {next = 1;} 
	   
   } else {
	   
	   next = current - 1; 
	   
	   if (next < 1) {next = cant;}	   	   
   }
   
   document.getElementById('h'+current).style.display = 'none';
   document.getElementById('h'+next).style.display = 'block';
   
   current = next;   
}	
</script>
