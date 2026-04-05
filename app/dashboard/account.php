<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Partners</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
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
validations.push({id:"password2",type:"compare:password", msg:"Both passwords must be the same"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:20px; display:inline-block; width:928px;">

    <div class="left_column" style="width:150px;">    
        <? include(ROOT_PATH . "/includes/account_menu.php") ?>
    </div>
    
    <div class="right_column" style="width:750px;">
    	<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br /><br />"; }?></span>
        Please keep your contact details up to date.<br /><br /><br /><br />
        
        <div class="conte_banners">
            <div class="conte_banners_header"><strong>Your Account</strong> </div>
            <div style="margin-left:20px;">
                <br />
                <form action="../process/actions/edit_account_action.php" method="POST" onsubmit="return validate(validations);">  
                <div class="form_box" style="width:500px;">
                    <table width="99%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td>First Name:</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->name ?>" name="firstname" id="firstname" size="50" maxlength="50">
                        </td>
                      </tr>
                      <tr>
                        <td>Last Name:</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->last_name ?>" name="lastname" id="lastname" size="50" maxlength="50">
                        </td>
                      </tr>
                    </table>
                </div>
                <div class="form_box" style="width:500px;">
                    <table width="99%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td>Address:</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->adress ?>" name="address" id="address" size="50" maxlength="100">
                        </td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->city ?>" name="city" id="city" size="50" maxlength="250">
                        </td>
                      </tr>
                      <tr>
                        <td>State</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->state ?>" name="state" id="state" size="50" maxlength="100">
                        </td>
                      </tr>
                      <tr>
                        <td>Country</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->country ?>" name="country" id="country" size="50" maxlength="100">
                        </td>
                      </tr>
                      <tr>
                        <td>Zip Code:</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->zip ?>" name="zipcode" id="zipcode" size="50" maxlength="50">
                        </td>
                      </tr>
                    </table>
                </div>
                <div class="form_box" style="width:500px;">
                    <table width="99%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td>Email</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->email ?>" name="email" id="email" size="50" maxlength="100">
                        </td>
                      </tr>
                      <tr>
                        <td>Phone</td>
                        <td style="text-align:right;">
                            <input type="text" value="<? echo $current_affiliate->phone ?>" name="phone" id="phone" size="50" maxlength="255">
                        </td>
                      </tr>    
                      <tr>
                        <td>Main Website Name:</td>
                        <td style="text-align:right;">
                        	<input type="text" value="<? echo $current_affiliate->web_name ?>" name="websitename" id="websitename" size="50" maxlength="255">
                        </td>
                      </tr>
                      <tr>
                        <td>Main Website URL:</td>
                        <td style="text-align:right;">
                        	<input type="text" value="<? echo $current_affiliate->web_url ?>" name="websiteurl" id="websiteurl" size="50" maxlength="255">
                        </td>
                      </tr>           
                    </table>
                </div>
                <div class="form_box" style="width:500px;">
                    <table width="99%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td><strong>Change Password</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Old Password:</td>
                        <td style="text-align:right;"><input type="password" name="old_pass" id="old_pass" size="50" maxlength="64"></td>
                      </tr>
                      <tr>
                        <td>New Password:</td>
                        <td style="text-align:right;"><input type="password" name="password" id="password" size="50" maxlength="64"></td>
                      </tr>
                      <tr>
                        <td>New Password (again):</td>
                        <td style="text-align:right;"><input type="password" name="password2" id="password2" size="50" maxlength="64"></td>
                      </tr>
                    </table>
                </div>   
                <br />
                
                <input type="image" src="../images/temp/submit.jpg" />
                </form>
            </div>
        </div>
    
    </div>

</div>
<? include "../includes/footer.php" ?>