function color_line(lid, on, style){
	if(style == undefined){style = "blue";}
	var line = document.getElementById(lid);
	tds = line.getElementsByTagName("td");
	for(var i = 0; i < tds.length; i++){
		if(on){
			tds[i].className += "_" + style;
		}else{
			tds[i].className = tds[i].className.replace("_"+style,"");
		}
	}
}
function payout_reject_action(tid, cstatus){
	var tform = document.getElementById("form_"+tid);
	var comments = document.getElementById("comments_"+tid);
	
	tform.submit();
	if(cstatus == "all"){
		color_line("row_"+tid, false, "red");
		color_line("row_"+tid, false);
		color_line("row_"+tid, true, "red");
	}else{
		document.getElementById("row_"+tid).style.display = "none";
	}	
}
function payout_mark_action(tid, cstatus){
	var tform = document.getElementById("form_"+tid);
	var comments = document.getElementById("comments_"+tid);
	var status = document.getElementById("admin_status_"+tid).value;	
	if(status == "ac"){
		comments.style.display = "none";
		comments.value = "";
		tform.submit();
		if(cstatus == "all"){
			color_line("row_"+tid, false, "red");
			color_line("row_"+tid, false);
			color_line("row_"+tid, true);
		}else{
			document.getElementById("row_"+tid).style.display = "none";
		}
	}else if(status == "re"){
		comments.style.display = "block";
	}else{
		comments.style.display = "none";
		comments.value = "";
		tform.submit();
		if(cstatus == "all"){
			color_line("row_"+tid, false, "red");
			color_line("row_"+tid, false);
		}else{
			document.getElementById("row_"+tid).style.display = "none";
		}
	}
}
function payout_set_to_clerk(tid, type){
	var iframe = document.getElementById("upi");
	var clerk = document.getElementById("admin_clerk_"+tid).value;
	iframe.src = "https://www.ezpay.com/wu/process/actions/apa_mark_transaction.php?tid="+tid+"&cl="+clerk+"&type="+type;	
}

function pop_shadow(url, title, width, heigth){
	Shadowbox.init({
			players:  [ 'iframe'] 
		});
		Shadowbox.open({
			player:     'iframe',
			title:      title,
			content:    url,
			height:     heigth,
			width:      width
		});
}

function set_select_input(ddlID, value, change){
	var ddl = document.getElementById(ddlID);
	for (var i = 0; i < ddl.options.length; i++) {
		if (ddl.options[i].value == value) {
			if (ddl.selectedIndex != i) {
				ddl.selectedIndex = i;
				if (change){ddl.onchange();}
			}
		   break;
	   }
   }
}

