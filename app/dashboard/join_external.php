<? include(ROOT_PATH . "/process/functions.php"); ?>
<?
$pfirst_name = $_COOKIE['firstname'];
$plast_name = $_COOKIE['lastname'];
$paddress = $_COOKIE['address'];
$pcity = $_COOKIE['city'];
$pstate = $_COOKIE['state'];
$pcountry = $_COOKIE['country'];
$pzip = $_COOKIE['zipcode'];
$pemail = $_COOKIE['email'];
$pphone = $_COOKIE['phone'];
$pwebname = $_COOKIE['websitename'] ;
$pweburl = $_COOKIE['websiteurl'];
clean_register_cookies();

$one_book = $_GET["ob"];
if($one_book == ""){$one_book = 1;}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style-new.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/skins/tango/skin.css" rel="stylesheet" type="text/css" />
<title>Partners Register</title>
</head>
<body style="background-image:none;background-color:transparent; padding-left:5px;">
<? //include "./includes/header-new.php" ?>
<script type="text/javascript" src="../process/js/functions.js"></script> 
<script type="text/javascript">
function refresh_captcha(){
	document.getElementById("captcha_image").src = "../includes/captcha.php?rand" + Math.floor(Math.random()*100);
}
var validations = new Array();
validations.push({id:"firstname",type:"null", msg:"The first name is required"});
validations.push({id:"lastname",type:"null", msg:"The last name is required"});
validations.push({id:"address",type:"null", msg:"The address is required"});
validations.push({id:"city",type:"null", msg:"The city is required"});
validations.push({id:"state",type:"null", msg:"The state is required"});
validations.push({id:"country",type:"null", msg:"The country is required"});
validations.push({id:"zipcode",type:"null", msg:"The zipcode is required"});
validations.push({id:"email",type:"email", msg:"You need to write a valid Email"});
validations.push({id:"phone",type:"null", msg:"The phone number is required"});
validations.push({id:"websitename",type:"null", msg:"The website name is required"});
validations.push({id:"websiteurl",type:"null", msg:"The website url is required"});
validations.push({id:"password",type:"null", msg:"You need to write your Password"});
validations.push({id:"password2",type:"compare:password", msg:"Both passwords must be the same"});
validations.push({id:"cks_books",type:"checkbox:checkbook,1", msg:"You must choose at least one sportsbook"});
validations.push({id:"confirmation",type:"null", msg:"You need to write the Security Code"});
</script>
<div class="wrapper_content" style="margin-top:5px">
  <div class="content_left" style="width:885px;">
    <div class="box_content_304" style="margin-right:7px;">
    <span class="error">
      <? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br />"; }?>
      </span>
      <span class="little">*All Fields Required</span><br />
      <form action="../process/actions/join-process.php" method="POST" name="join" id="join" onsubmit="return validate(validations);">
      <input type="hidden" value="1" name="external" id="external" />
      <input type="hidden" value="<? echo $one_book ?>" name="one_book" id="one_book" />
        <div class="form_box" style="width:300px;">
          <table width="99%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>First Name:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pfirst_name ?>" name="firstname" id="firstname" size="15" maxlength="50"></td>
            </tr>
            <tr>
              <td>Last Name:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $plast_name  ?>" name="lastname" id="lastname" size="15" maxlength="50"></td>
            </tr>
          </table>
        </div>
        <div class="form_box" style="width:300px;">
          <table width="99%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>Address:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $paddress ?>" name="address" id="address" size="15" maxlength="100"></td>
            </tr>
            <tr>
              <td>City:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pcity; ?>" name="city" id="city" size="15" maxlength="250"></td>
            </tr>
            <tr>
              <td>State</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pstate ?>" name="state" id="state" size="15" maxlength="100"></td>
            </tr>
            <tr>
              <td>Country</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pcountry ?>" name="country" id="country" size="15" maxlength="100"></td>
            </tr>
            <tr>
              <td>Zip Code:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pzip ?>" name="zipcode" id="zipcode" size="15" maxlength="50"></td>
            </tr>
          </table>
        </div>
        <div class="form_box" style="width:300px;">
          <table width="99%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>Email</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pemail ?>" name="email" id="email" size="15" maxlength="100"></td>
            </tr>
            <tr>
              <td>Phone</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pphone ?>" name="phone" id="phone" size="15" maxlength="255"></td>
            </tr>
            <tr>
              <td>Website Name:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pwebname ?>" name="websitename" id="websitename" size="15" maxlength="255"></td>
            </tr>
            <tr>
              <td>Website URL:</td>
              <td style="text-align:right;"><input type="text" value="<? echo $pweburl ?>" name="websiteurl" id="websiteurl" size="15" maxlength="255"></td>
            </tr>
            <tr>
              <td>Password:</td>
              <td style="text-align:right;"><input type="password" name="password" id="password" size="15" maxlength="64"></td>
            </tr>
            <tr>
              <td>Password (again):</td>
              <td style="text-align:right;"><input type="password" name="password2" id="password2" size="15" maxlength="64"></td>
            </tr>
            <tr>
              <td>I would like to subscribe to the monthly newsletter:</td>
              <td style="text-align:left;"><input name="newsletter" type="checkbox" id="newsletter" value="1" checked="checked" /></td>
            </tr>
          </table>
        </div>
        <div class="form_box" style="width:300px; display:none">
          <table width="99%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>Choose Sportsbooks:</td>
              <td style="text-align:right;"><div id="cks_books">
                  <? $sportsbooks = get_all_sportsbooks();
		   		foreach($sportsbooks as $book){ ?>
                  <input <? if($book->id == $one_book){echo 'checked="checked"';} ?> type="checkbox" name="chkboxes[]" id="checkbook_<? echo $book->id ?>" value="<? echo $book->id ?>">
                  &nbsp;<? echo $book->name ?>
                  <? } ?>
                </div></td>
            </tr>
          </table>
        </div>
        <!--<div class="form_box" style="width:300px;">
          <table width="99%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>
              	<img src="../includes/captcha.php" id="captcha_image"> <br />
                <a href="javascript:;" onclick="refresh_captcha();" style="font-size:10px;">New Image</a>
                
              </td>
              <td>Type the code shown:<br /><input type="text" name="confirmation" id="confirmation" size="10" maxlength="64"></td>
            </tr>
          </table>
        </div>-->
        <input type="hidden" name="confirmation" id="confirmation" value="nc@njk!" >
        <br />
        <div align="center"><input type="image" src="../images/temp/join_btn.jpg" /></div>
      </form>
    </div>
  </div>
</div>
