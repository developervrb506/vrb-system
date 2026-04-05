
<?php 
$link="ftp://monitor:monitor@192.168.10.50//";
// External IP 190.7.216.196
?>
<!DOCTYPE html>
<html>
<head>
<script>
function Play(callid)
{
document.getElementById("audio").innerHTML= "<embed width='200' src='<? echo $link ?>"+callid+".gsm' >";
}


function error(){ alert("File is not here"); }

</script>
</head>



<body>
<form>
<table width="337" border="1">
  <tr>
    <th width="144" scope="col">Call id</th>
    <th width="106" scope="col">Date</th>
    <th width="65" scope="col">Audio</th>
  </tr>
  <tr>
    <td>
     <input id='callid' name='callid' value="1384543189.80858">
     </td>
     <td>05-5-2013</td>
    <td><a href="javascript:void(0)" onClick="Play(callid.value);">Audio</a></td>
  </tr>
</table>
</form>
<div id = "audio" name= "audio"></div>
</body>
</html>

<?php

check_ftp_audio_exist_test('1384543189.80858');
echo "<BR>";




function check_ftp_audio_exist_test($audio){
	
	$audio .= ".gsm";
	$ftp_server = "190.7.216.196";
	$ftp_user = "monitor";
	$ftp_pass = "monitor";
	
	$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
	$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
	$res = ftp_size($conn_id, $audio);
	echo $res;
	if ($res > 1 ) {
		ftp_close($conn_id);  
		echo "YES";
		return true;
	} else {
	    ftp_close($conn_id);  
	   echo "NO";
	    return false;
	}
}



?>