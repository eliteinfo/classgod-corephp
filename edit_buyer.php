<?php
include 'lib/module.php';
if($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if($_SESSION['clg_usertype']==1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
$arrCountry = $objModule->getCountry();
if($_POST['btnEditPro']!='')
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_users","Id");
    $objData->setFieldValues("fname",$_POST['txtFName']);
    $objData->setFieldValues("lname",$_POST['txtLName']);
    $objData->setFieldValues("description",stripslashes($_POST['txtDescription']));
    $objData->setFieldValues("State",$_POST['txtState']);
    $objData->setFieldValues("City",$_POST['txtCity']);
    $objData->setFieldValues("Zipcode",$_POST['txtZip']);
    $objData->setFieldValues("Country",$_POST['cmbCountry']);
    $objData->setFieldValues("Contact_no",$_POST['Phone']);
    if($_POST['txtPassword']!=''):
        $objData->setTableDetails("Password",md5($_POST['txtPassword']));
    endif;
    if($_FILES['txtFile']['name']!='')
    {
       $strEx           =   pathinfo($_FILES['txtFile']['name'],PATHINFO_EXTENSION);
       $strFilename     = uniqid().".".$strEx;
       move_uploaded_file($_FILES['txtFile']['tmp_name'],"upload/user/".$strFilename);
       $objData->setFieldValues("Photo",$strFilename);
       if($_POST['hdnFile']!='')
       {
           $strDel = "upload/user/".$_POST['hdnFile'];
           unlink($strDel);
       }
    }
    $objData->setWhere("Id = '".$_SESSION['clg_userid']."' ");
    $objData->update();
    unset($objData);
    $objModule->redirect("./buydashboard.php");
}
$arrUserDetail = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' AND User_type = '0' ");
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
           });
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
           <h1>Edit Profile</h1>
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
<div class="creat_acct">
<br/>
<p>
    <form method="POST" id="frmRegister" name="frmRegister" enctype="multipart/form-data" onsubmit="return frmvalidate(this.id)">
               <input type="text" name="txtFName" value="<?php echo $arrUserDetail[0]['fname'];?>" class="required" placeholder="First Name *" /><br/>
               <input type="text" name="txtLName" class="required" value="<?php echo $arrUserDetail[0]['lname'];?>" placeholder="Last Name *" /><br/>
               <input type="password" name="txtPassword" class="password" placeholder="Password" /><br/>
               <input type="text" name="txtUniversity" id="txtUni" placeholder="Enter the university name" class="" style="display: none;"/>
               <textarea name="txtDescription"><?php echo stripslashes($arrUserDetail[0]['description']);?></textarea>
               <br/>
               <select name="cmbCountry" id="cmbCountry" class="required">
                    <option value="">Select Country</option>
                    <?php foreach ($arrCountry as $strCounty): ?>
                        <option value="<?php echo $strCounty['Id']; ?>" <?php if ($strCounty['Id'] == $_POST['cmbCountry']): echo 'selected';
                    endif; ?>><?php echo $strCounty['Name']; ?></option>
                   <?php endforeach; ?>    
                </select>
               <br/>
               <input type="text" name="txtState" class="required" placeholder="State" value="<?php echo $arrUserDetail[0]['State'];?>" />
               <input type="text" name="txtCity" placeholder="City" class="required" value="<?php echo $arrUserDetail[0]['City'];?>" />
               <br/>
               <input type="text" name="txtZip" class="required" placeholder="Zipcode" value="<?php echo $arrUserDetail[0]['Zipcode'];?>" />
               <input type="text" class="required" placeholder="What's your phone number?" name="Phone"/><br/>
               <br/>
               <?php if(file_exists("upload/user/".$arrUserDetail[0]['Photo']) && $arrUserDetail[0]['Photo']!=''):?>
                    <img width="100" height="100" src="upload/user/<?php echo $arrUserDetail[0]['Photo'];?>" />
                    <br/>
               <?php endif;?>
               <input type="file" name="txtFile" placeholder="Upload Image" /><br/>
               <input type="hidden" value="<?php echo $arrUserDetail[0]['Photo'];?>" name="hdnFile" /> 
               <p><input type="submit" name="btnEditPro" value="Save" /></p>
           </form>
</p>
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
       if(!checkEmail(strEmail))
       {
           jQuery("#txtEmail").css("border",'1px solid red');
           jQuery("#txtEmail").attr("placeholder", "Enter valid email address");
           jQuery("#txtEmail").focus();
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
                       jQuery("#emailchk").show();
                       return false;
                   }
                   else
                   {
                       jQuery("#emailchk").hide();
                       return true;
                   }
               }
           });
       }
   }
   function chkUsername(strUsername)
   {
       jQuery("#userchk").hide();
       if(strUsername=='')
       {
           jQuery("#txtUsername").css("border",'1px solid red');
           jQuery("#txtUsername").focus();
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
                       jQuery("#userchk").hide();
                       return true;
                   }
               }
           });
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
</script>    