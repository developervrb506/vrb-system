<?
$l = $_GET["l"];
$x = $_GET["x"];
$deptid = $_GET["deptid"];
$agsite = $_GET["agsite"];
$mobile = $_GET["mobile"];
$type = $_GET["type"];
$name = $_GET["name"];
$email = $_GET["email"];

switch($type){
	case "cc_denied":
		$text = "We notice there was a problem with your deposit. Dont worry is very common and we are here to help.";
	break;
}
?>

<script type="text/javascript" src="js/chat_fn.js"></script>
<script type="text/javascript" src="js/xmlhttp.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" language="JavaScript1.2">
<!--

function init()
{
	// Check for browser support
	if ( !document.createElement && !document.createElementNS ) self.location.href = "http://www.osicodes.com/demos/phplive/browser.php";
	if ( !initxmlhttp() ) self.location.href = "http://www.osicodes.com/demos/phplive/browser.php?xmlhttp=1";
	open_chat() ;
}

window.onload = init;

var win_width = window.screen.availWidth ;
var win_height = window.screen.availHeight ;

var now = new Date() ;
var day = now.getDate() ;
var time = ( now.getMonth() + 1 ) + '/' + now.getDate() + '/' +  now.getYear() + ' ' ;

var hours = now.getHours() ;
var minutes = now.getMinutes() ;
var seconds = now.getSeconds() ;

if (hours > 12){
	time += hours - 12 ;
}  else
if (hours > 10){
	time += hours ;
} else
if (hours > 0){
	time += "0" + hours ;
} else
	time = "12" ;

time += ((minutes < 10) ? ":0" : ":") + minutes ;
time += ((seconds < 10) ? ":0" : ":") + seconds ;
time += (hours >= 12) ? " P.M." : " A.M." ;

function do_submit()
{
	var dept_checked = 0 ;
			
	if ( document.form.deptid.value )
		dept_checked = 1 ;
	else
	{
		for( c = 0; c < document.form.deptid.length; ++c )
		{
			if ( document.form.deptid[c].checked )
				dept_checked = 1 ;
		}
	}

	if ( ( document.form.from_screen_name.value == "" ) || ( document.form.question.value == "" ) || ( dept_checked == 0 ) )
	{
		alert( "Please provide ALL fields." ) ;
		//document.form.question.value = ' ' + document.form.question.value ;			
		//document.form.question.value = 'SPORTS BETTING ONLINE CHAT REQUEST ' + document.form.question.value ;
	}
	else if ( document.form.email.value.indexOf("@") == -1 )
	{
		alert( "Email is invalid format (example: someone@somewhere.com)" ) ;
		//document.form.question.value = ' ' + document.form.question.value ;			
		//document.form.question.value = 'SPORTS BETTING ONLINE CHAT REQUEST ' + document.form.question.value ;
	}
	else
	{
		document.form.display_width.value = win_width ;
		document.form.display_height.value = win_height ;
		document.form.datetime.value = time ;
		document.form.question.value = ' ' + document.form.question.value ;			
		//document.form.question.value = 'SPORTS BETTING ONLINE CHAT REQUEST ' + document.form.question.value ;
		document.form.submit() ;
	}
}

function open_chat()
{
		}

function opennewwin(url)
{
	window.open(url, "newwin", "scrollbars=yes,menubar=yes,resizable=1,location=yes,toolbar=yes") ;
}

//-->
</script>
<form method="post" action="request.php" name="form" id="chatform">
    <input type="hidden" name="action" value="request">
    <input type="hidden" name="display_width" value="">
    <input type="hidden" name="display_height" value="">
    <input type="hidden" name="datetime" value="">
    <input type="hidden" name="x" value="<? echo $x ?>">
    <input type="hidden" name="l" value="<? echo $l ?>">
    <input type="hidden" name="pagex" value="Email Signature">
    <input type="hidden" name="ins" value="">
    <input type="hidden" name="agsite" value="<?php /*?>SPORTS BETTING ONLINE CHAT REQUEST<?php */?>">
    <input type="hidden" name="agsite_desc" value="<? echo $agsite ?>">
    <input type="hidden" name="mobile" value="<? echo $mobile ?>">
    <input type="hidden" name="deptid" value="<? echo $deptid ?>">   
    <input type="hidden" id="user_name" name="from_screen_name"  value="<? echo $name ?>" onKeyPress="return noquotes(event)" />
    <input type="hidden" id="email" name="email" value="<? echo $email ?>" />
    <input type="hidden" id="message" name="question" value="<? echo $text ?>" />
</form>
<script type="text/javascript">do_submit();</script>