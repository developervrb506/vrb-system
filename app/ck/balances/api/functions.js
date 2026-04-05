function load_system_accounts(div, system, name, select_option){
	document.getElementById(div).innerHTML = "Loading Accounts...";
	var url = "ck/balances/api/accounts.php";
	url += "?sys="+system+"&nm="+name+"&so="+select_option;
	get_external_content(url, div)
}