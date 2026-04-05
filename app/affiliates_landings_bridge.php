<?
include(ROOT_PATH . "/ck/process/functions.php");  
$site = param("site");

switch ($site){
	
	case "bitbet":	  
	
	  $name   = param("name");	  
      $last   = param("last");
      $email  = param("email");
      $sboaff = param("sboaff");
      $sboaid = param("sboaid");
      $sbopid = param("sbopid");
      $sbocc  = param("sbocc");	  
	  $link = "http://www.bitbet.com/utilities/process/actions/register/landing_redirect.php?name=".$name."&last=".$last."&email=".$email."&sboaff=".$sboaff."&sboaid=".$sboaid."&sbopid=".$sbopid."&sbocc=".$sbocc;
	break;
	
	case "owi":
	
	  $name   = param("name");
      $last   = param("last");
      $email  = param("email");
      $sboaff = param("sboaff");
      $sboaid = param("sboaid");
      $sbopid = param("sbopid");
      $sbocc  = param("sbocc");	  
	  $link = "http://www.betowi.com/utilities/process/register/landing_redirect.php?name=".$name."&last=".$last."&email=".$email."&sboaff=".$sboaff."&sboaid=".$sboaid."&sbopid=".$sbopid."&sbocc=".$sbocc;
	break;
	
	case "hrb":
	
	  $name   = param("name");
      $last   = param("last");
      $email  = param("email");
      $hrbaff = param("hrbaff");
      $hrbaid = param("hrbaid");
      $hrbpid = param("hrbpid");
      $hrbcc  = param("hrbcc");	  
	  $link = "http://www.horseracingbetting.com/utilities/process/register/landing_redirect.php?name=".$name."&last=".$last."&email=".$email."&hrbaff=".$hrbaff."&hrbaid=".$hrbaid."&hrbpid=".$hrbpid."&hrbcc=".$hrbcc;
	break;	
}

header("Location: ".$link); 
exit();
?>