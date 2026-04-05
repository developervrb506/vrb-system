
<?
 $user_logins = get_all_clerk_phone_logins($current_clerk->vars["id"]);
		  $str_logins =" ";
		  echo '<span style="font-size:11px" title="Please use only your Logins"><strong>Your Phone Logins:</strong>';
		  foreach ($user_logins as $user_login){
			  $str_logins .=  $user_login->vars["comment"].": ".$user_login->vars["login"]." | ";
			}
		   $str_logins = substr($str_logins,0,-2);	
          echo $str_logins;
?>
</span>