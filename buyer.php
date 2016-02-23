<?php
include 'lib/module.php';
//$arrCountry = $objModule->getAll("SELECT * FROM tbl_country ORDER BY Name ASC");
if($_POST['btnRegister']!='')
{
    $strEmail = $_POST['txtEmail'];
    if($_POST['txtEmail']!='' && $_POST['txtUsername']!='' && $_POST['txtFName']!='' && $_POST['txtLName']!='')
    {
        $arrExist = $objModule->getAll("SELECT (SELECT COUNT(*) FROM tbl_users WHERE Email = '".$_POST['txtEmail']."') as temail,(SELECT COUNT(*) FROM tbl_users WHERE Username = '".$_POST['txtUsername']."') as tuname ");
        if($arrExist[0]['temail']!=0)
        {
            $objModule->setMessage("Email-id already register in our system","error");
        }
        else if($arrExist[0]['tuname']!=0)
        {
            $objModule->setMessage("Username already register in our system","error");
        }
        else
        {
            $strUniqId = uniqid();
            $objData = new PCGData();
            $objData->setTableDetails("tbl_users","Id");
            $objData->setFieldValues("fname",$_POST['txtFName']);
            $objData->setFieldValues("lname",$_POST['txtLName']);
            $objData->setFieldValues("Email",$_POST['txtEmail']);
            $objData->setFieldValues("Username",$_POST['txtUsername']);
            $objData->setFieldValues("Password",md5($_POST['txtPassword']));
            $objData->setFieldValues("User_type",'0');
            $objData->setFieldValues("Status",'0');
            $objData->setFieldValues("verify_code",$strUniqId);
            $objData->setFieldValues("university",$_POST['txtUniversity']);
            
            $objData->setFieldValues("Creation_date",date("Y-m-d H:i:s"));
            $objData->insert();
            $intLastId = $objData->intLastInsertedId;
            unset($objData);
            if($intLastId!='')
            {
                $strMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Metronic | Email 1</title>
	<style type="text/css">
		#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
		body{width:100% !important; margin:0; font-family:Open Sans;} 
		body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
		body{margin:0; padding:0;}
		img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
		table td{border-collapse:collapse;}
		#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700); /* Loading Open Sans Google font */ 
		body, #backgroundTable{ background-color:#FFF; }
		.TopbarLogo{
		padding:10px;
		text-align:left;
		vertical-align:middle;
		}
		h1, .h1{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:35px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h2, .h2{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:30px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h3, .h3{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:24px;
		font-weight:400;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h4, .h4{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:18px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h5, .h5{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:14px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		.textdark { 
		color: #444444;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.textwhite { 
		color: #fff;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.fontwhite { color:#fff; }
		.btn {
		background-color: #e5e5e5;
		background-image: none;
		filter: none;
		border: 0;
		box-shadow: none;
		padding: 7px 14px; 
		text-shadow: none;
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		font-size: 14px;  
		color: #333333;
		cursor: pointer;
		outline: none;
		-webkit-border-radius: 0 !important;
		-moz-border-radius: 0 !important;
		border-radius: 0 !important;
		}
		.btn:hover, 
		.btn:focus, 
		.btn:active,
		.btn.active,
		.btn[disabled],
		.btn.disabled {  
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		color: #333333;
		box-shadow: none;
		background-color: #d8d8d8;
		}
		.btn.red {
		color: white;
		text-shadow: none;
		background-color: #d84a38;
		}
		.btn.red:hover, 
		.btn.red:focus, 
		.btn.red:active, 
		.btn.red.active,
		.btn.red[disabled], 
		.btn.red.disabled {    
		background-color: #bb2413 !important;
		color: #fff !important;
		}
		.btn.green {
		color: white;
		text-shadow: none; 
		background-color: #35aa47;
		}
		.btn.green:hover, 
		.btn.green:focus, 
		.btn.green:active, 
		.btn.green.active,
		.btn.green.disabled, 
		.btn.green[disabled]{ 
		background-color: #1d943b !important;
		color: #fff !important;
		}
	</style>
</head><body>';
                $strMessage .='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343; height:52px;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="left" valign="middle" style="padding-left:20px; padding-top:5px;">
								<a href="'.$objModule->SITEURL.'">
								<img src="'.$objModule->SITEURL.'images/logo2.png" width="246px" alt="Metronic logo"/>
								</a>
							</td>
							<td align="right" valign="middle" style="padding-right:0; padding-top:5px;">
								<table border="0" cellpadding="0" cellspacing="0" width="120px" style="height:100%;">
									<tr>
										<td>
											<a href="#">
											<img src="'.$objModule->SITEURL.'images/fb_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="'.$objModule->SITEURL.'images/tw_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="'.$objModule->SITEURL.'images/youtube_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:1px solid #e7e7e7;">
		<tr>
			<td>
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td valign="top" style="padding:20px;">
								<h2>Welcome to ClassGod!</h2>
								<br />
								<div class="textdark">
									<strong>Getting started:</strong> 
									To finish your registration and hire freelancers, there is one more quick step:<br/>
                                                                        <a href="'.$objModule->SITEURL.'confirm.php?h='.base64_encode($strUniqId).'&u='.$intLastId.'">click to verify your email address</a>
                                                                        
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;">
								&copy; '.date("Y").' ClassGod.
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>';
                $headers = "From: ClassGod<".$objModule->INFO_MAIL.">". "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                mail($_POST['txtEmail'],"Registration done successfully",$strMessage,$headers);
                $objModule->redirect("thanks.php?u=".  base64_encode($intLastId));
                
            }
        }
    }
    else
    {
        $objModule->setMessage("Please filled the required fields","error");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("ul.menu li:has(ul)").addClass("parent");
                $(".menu_link").click(function () {
                    $(this).next("ul").slideToggle(400);
                    return false;
                });
                $(".menu_link").toggle(function () {
                    $(this).addClass("active");
                }, function () {
                    $(this).removeClass("active");
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".custom-select").each(function () {
                    $(this).wrap("<span class='select-wrapper'></span>");
                    $(this).after("<span class='holder'></span>");
                });
                $(".custom-select").change(function () {
                    var selectedOption = $(this).find(":selected").text();
                    $(this).next(".holder").text(selectedOption);
                }).trigger('change');
            })
        </script>
    </head>
    <body>
        <!----Top Start---->
        <?php include('includes/header_top.inc.php'); ?>
        <!----Top End----> 
<!----header Start---->
<div class="header">
  <ul class="slides">
    <li>
      <div class="header_main">
        <div class="header_img"><img src="images/about_inner.jpg" alt="" /></div>
        <div class="header_textbox">
          <div class="wrapper">
            <h1>Buyer</h1>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
<!------Header End----> 
<!----mid Start---->
<div class="mid">
<div class="wrapper"> 
<!----content Start---->
<div class="content_part">
<h2 class="title2">Create an Account</h2>  
Looking for work? <a href="<?php echo $objModule->SITEURL;?>contractor.php">Sign up as a Freelancer</a>. Have an account? <a href="<?php echo $objModule->SITEURL;?>login.php">Sign In</a>.<br />
<div class="regform">
 <?php echo $objModule->getMessage();?>
            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return !!(frmvalidate(this.id)) && (frmPolicy());" >
            
            <div class="row">
            	<div class="one_half"><input type="text" name="txtFName" value="<?php if(isset($_POST['txtFName'])): echo $_POST['txtFName'];endif;?>" class="required" placeholder="First Name *" onkeypress="return onlyAlphabets(event,this);" /></div>
                <div class="one_half last"><input type="text" name="txtLName" class="required" placeholder="Last Name *"  value="<?php if(isset($_POST['txtLName'])): echo $_POST['txtLName'];endif;?>" onkeypress="return onlyAlphabets(event,this);" /></div>
            </div>
            <div class="row">
            	<div class="one_full"><input type="text" name="txtEmail" id="txtEmail"  value="<?php if(isset($_POST['txtEmail'])): echo $_POST['txtEmail'];endif;?>" class="required email" placeholder="Email *" onblur="chkEmail(this.value);" /><br/>
                <div id="emailchk" style="display: none;">
                    <span style="font-size:11px;color:#f00">Your email already exists. 
                        <a id="forgotpage" href="<?php echo $objModule->SITEURL;?>forgotpass.php">Retrieve your account.</a></span>
                </div></div>
            </div>
            <div class="row">
            	<div class="one_full"><input type="text" name="txtUsername" id="txtUsername" value="<?php if(isset($_POST['txtUsername'])): echo $_POST['txtUsername'];endif;?>" class="required uname" placeholder="Username *" onblur="chkUsername(this.value);" /><br/>
                <div id="userchk" style="display: none;"><span style="font-size:11px;color:#f00">Username exists, please try a different username.</span></div></div>
            </div>
            <div class="row">
            	<div class="one_half"><input type="password" name="txtPassword" class="required password" placeholder="Password *" /></div>
                <div class="one_half last"><input type="password" name="txtConfPassword" class="required confpass" placeholder="Retype Password *" /></div>
            </div>
            <div class="row">
            	<div class="one_full"><input type="text" name="txtUniversity" id="txtUni" placeholder="Enter the university name" class="" style="display: none;"/></div>
            </div>
			 <div class="row">
       		<div class="one_full chkrad chkterms">
                 <div class="formrow highlightError" id="tosFieldErr" type="error">
                    <label> <input type="checkbox" class="required" name="tos" id="tos">
                  <span style="display:block;">by checking this box<a target="_blank" href="terms.php"> I agree to all terms and conditions of ClassGod</a> and also to abide to my own academic institution's policy on academic integrity.</span></label>
           <div id="privacychk" style="display: none;"> <span style="font-size:11px;color:#f00">Please agreed terms of service.</span> </div>
           <div class="clear"></div>
         </div>
               </div>
       </div>
            <div class="row">
            	<div class="one_full"><input type="submit" name="btnRegister"  value="Continue" /></div>
            </div>
            </form>

</div>
</div>
    <!----content End----> 
  </div>
</div>
<!----mid End----> 
<!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?>
    </body>
</html>
<script type="text/javascript">
    function chkEmail(strEmail)
    {
        jQuery("#emailchk").hide();
        var intFl = false;
        if(strEmail!='')
        {
            
        if(!checkEmail(strEmail))
        {
            jQuery("#txtEmail").css("border",'1px solid red');
            jQuery("#txtEmail").val('');
            jQuery("#txtEmail").attr("placeholder", "Enter valid email address");
            //jQuery("#txtEmail").focus();
            return false;
        }
        else
        {
            if(validateEmail(strEmail)==true)
            {
                jQuery("#txtUni").show();
                jQuery("#txtUni").addClass("required");
            }
            else
            {
                jQuery("#txtUni").hide();
                jQuery("#txtUni").removeClass("required");
            }
            jQuery.ajax({
                url: 'ajax.php',
                data: {strEmail:strEmail,CMD:"CHECK_EMAIL"},
                type: 'POST',
                cache: true,
                success: function (data)
                {
                    if(data==0)
                    {
						jQuery('#forgotpage').attr('href','<?php echo $objModule->SITEURL;?>forgotpass.php?email='+strEmail);
						
                        jQuery("#emailchk").show();
                        //jQuery("#txtEmail").focus();
                        return false;
                    }
                    else
                    {
                        jQuery("#txtEmail").css('border','1px solid #ccc');
                        jQuery("#emailchk").hide();
                        return true;
                    }
                }
            });
        }
        }
    }
    function chkUsername(strUsername)
    {
        jQuery("#userchk").hide();
        if(strUsername!='')
        {
            if(strUsername=='')
            {
                jQuery("#txtUsername").css("border",'1px solid red');
                return false;
            }
            else
            {
                jQuery.ajax({
                    url: 'ajax.php',
                    data: {strUsername:strUsername,CMD:"CHECK_USERNAME"},
                    type: 'POST',
                    cache: true,
                    success: function (data)
                    {
                        if(data==0)
                        {
                            jQuery("#userchk").show();
                            return false;
                        }
                        else
                        {
                            jQuery("#txtUsername").css('border','1px solid #ccc');
                            jQuery("#userchk").hide();
                            return true;
                        }
                    }
                });
            }
        }
    }
function validateEmail(email) 
{
   var strEx = email.slice(-4);
   if(strEx==".edu")
   {
       return true;
   }
   return false;
}


function onlyAlphabets(e, t) {
            if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
				}
                else { return true; }
                
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode==32) || (charCode==8) || (charCode==46) || (charCode==0) || (charCode==16) || (charCode==16) || (charCode==39))
                    return true;
                else
                    return false;
            }
 function frmPolicy()
   {
       if (jQuery("#tos").prop("checked") == false)
       {
           jQuery("#privacychk").show();
           return false;
       }
       else
       {
           jQuery("#privacychk").hide();
           return true;
       }
   }			
</script>   