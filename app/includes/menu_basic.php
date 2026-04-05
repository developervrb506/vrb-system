<div class="menu" id="menudiv">
    <div id="menu_header">
     <ul class="nav">
        
        
        <li><a href= "http://localhost:8080/ck/index.php?demo=1">Home</a></li>
        <li><a href= "http://localhost:8080/ck/settings.php">Settings</a></li>
        <li><a href= "http://localhost:8080/ck/token_generator.php">Tokens</a></li>
        <li><a href= "http://localhost:8080/ck/clerks.php">Users</a></li>
        <li><a href= "http://localhost:8080/ck/permissions_user.php">User Perm</a></li>
        <li><a href= "http://localhost:8080/ck/user_groups.php">Groups</a></li>
        <li><a href= "http://localhost:8080/ck/permissions_group.php">Group Perm</a></li>
        <li><a href= "http://localhost:8080/ck/rules.php">Rules</a></li>
        <li><a href= "http://localhost:8080/ck/goals.php">Goals</a></li>
        <li><a href= "http://localhost:8080/ck/changed_players.php">P-Changes</a></li>
        <li><a href= "http://localhost:8080/ck/changed_wagers.php">B-Changes</a></li>
        <li><a href= "http://localhost:8080/ck/messages.php">Messages</a></li>
        
      </ul>
    </div>
</div>

<div style="font-size:12px; font-weight:normal; text-align:right; font-weight:bold; margin-top:3px; position:">
	<? echo date("Y-m-d / h:i:s a"); ?> ET
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href= "http://localhost:8080/process/login/logout.php" class="normal_link">LOGOUT</a>
</div>




<script type="text/javascript">
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
