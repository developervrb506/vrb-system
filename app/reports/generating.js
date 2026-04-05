function get_results(url, div, code){
		if(location.href.indexOf("www.") != -1){
			url = "http://localhost:8080/" + url;
		}else{
			url = "http://vrbmarketing.com/" + url;
		}
		if (window.XMLHttpRequest) {    
			req = new XMLHttpRequest();    
		}    
		else if (window.ActiveXObject) {  
			req = new ActiveXObject("Microsoft.XMLHTTP");    
		}
		return read_content_FromFile(url, req, div, code);
}
function read_content_FromFile(filename, req, div, code) {
	req.open('GET', filename);
	req.onreadystatechange = function() {   
		if (req.readyState == 4) {
			content = req.responseText;
			if(content == ""){content = "No Information Available!!";}
			if(document.getElementById(div) != null){
				document.getElementById(div).innerHTML = content;
				if(code != null){setTimeout(code,1);}
			}
		} 
	}
	req.send("");
}