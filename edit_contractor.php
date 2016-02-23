<?php
include 'lib/module.php';
if($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if($_SESSION['clg_usertype']==0)
{
    // redirect to tutor dashboard
    $objModule->redirect("./buydashboard.php");
}
$arrCategory = $objModule->getCategory();
$arrCountry = $objModule->getCountry();
$arrSkills = $objModule->getAll("SELECT tss.* FROM tbl_skills tss ORDER BY sk_id ASC");
if($_POST['btnEditPro']!='')
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_users","Id");
    $objData->setFieldValues("fname",$_POST['txtFName']);
    $objData->setFieldValues("lname",$_POST['txtLName']);
    $objData->setFieldValues("description",$_POST['txtDescription']);
    $objData->setFieldValues("State",$_POST['txtState']);
    $objData->setFieldValues("City",$_POST['txtCity']);
    $objData->setFieldValues("Zipcode",$_POST['txtZip']);
    $objData->setFieldValues("Country",$_POST['cmbCountry']);
    $objData->setFieldValues("Contact_no",$_POST['Phone']);
    if(!empty($_POST['skills']))
    {
        $strSki = @implode(',', $_POST['skills']);
        $objData->setFieldValues("skills",$strSki);
    }
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
    //echo "<pre>";print_r($objData->getSQL());die;  
    unset($objData);
    $objModule->redirect("./tutors_profile.php");
}
$arrUserDetail = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' AND User_type = '1' ");
//echo "<pre>";print_r($arrUserDetail);die;
$arrEditSkill       = array();
if($arrUserDetail[0]['skills']!='')
{
    $arrEditSkill = @explode(',', $arrUserDetail[0]['skills']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
       <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
       <title>Class God</title>
       <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
       <link href="css/style.css" rel="stylesheet" type="text/css" />
       <script type="text/javascript" src="js/script.js"></script>
       <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
       <script type="text/javascript" src="js/jquery.fancybox.js"></script>
       <script type="text/javascript" src="js/common.js"></script>
       <script type="text/javascript">
           $(document).ready(function () {
                $(".various").fancybox({
                        maxWidth	: 800,
                        maxHeight	: 600,
                        fitToView	: false,
                        width		: '70%',
                        height		: '70%',
                        autoSize	: false,
                        closeClick	: false,
                        openEffect	: 'none',
                        closeEffect	: 'none'
                });
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
<div class="sidebar">
                        <a class="category_top" href="#">Category</a>
                        <div class="category_box">
                            <div class="sidebar_box">
                                <h2><span>Profile</span></h2>
                                <ul>
                                    <li><a href="tutors_profile.php">Overview</a></li>
                                    <li><a href="#">Job History</a></li>
                                    <li><a href="edit_skills.php">Skills</a></li>
                                    <li><a href="edit_contractor.php">Contact Info</a></li>
                                    <li><a href="#">Review</a></li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <ul class="short_profile">
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon16.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>5.00</span></div>
                                        <div class="small_txt"><span><img src="images/icon15.png" alt="" /></span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon17.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>$99.66</span></div>
                                        <div class="small_txt"><span>Hourly Rate</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon18.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>15</span></div>
                                        <div class="small_txt"><span>Total Job Worked</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon19.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>2,339</span></div>
                                        <div class="small_txt"><span>Total Hours</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon20.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>Croatia</span></div>
                                        <div class="small_txt"><span>Opatija</span></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <h2><span>Groups</span></h2>
                                <ul>
                                    <li><a href="#">Group A</a></li>
                                    <li><a href="#">Group B</a></li>
                                    <li><a href="#">Group C</a></li>
                                    <li><a href="#">Group D</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
<div class="blog_part">
                        <div class="blog_box">
    <form method="POST" id="frmRegister" name="frmRegister" enctype="multipart/form-data" onsubmit="return frmvalidate(this.id)">
               <input type="text" name="txtFName" value="<?php echo $arrUserDetail[0]['fname'];?>" class="required" placeholder="First Name *" /><br/>
               <input type="text" name="txtLName" class="required" value="<?php echo $arrUserDetail[0]['lname'];?>" placeholder="Last Name *" /><br/>
               <input type="password" name="txtPassword" class="password" placeholder="Password" /><br/>
               <input type="text" name="txtRate" class="required" value="<?php echo $arrUserDetail[0]['h_rate'];?>" placeholder="Hourly rate *" /><br/>
               <br/>
               <textarea name="txtDescription" class="required" placeholder="About me"><?php echo stripslashes($arrUserDetail[0]['description']);?></textarea>
               <br/>
               <select name="cmbCountry" id="cmbCountry" class="required">
                    <option value="">Select Country</option>
                    <?php foreach ($arrCountry as $strCounty): ?>
                        <option value="<?php echo $strCounty['Id']; ?>" <?php if ($strCounty['Id'] == $arrUserDetail[0]['Country']): echo 'selected';
                    endif; ?>><?php echo $strCounty['Name']; ?></option>
                   <?php endforeach; ?>    
                </select>
               <br/>
               <input type="text" class="required" name="txtState" placeholder="State" value="<?php echo $arrUserDetail[0]['State'];?>" />
               <input type="text" class="required" name="txtCity" placeholder="City" value="<?php echo $arrUserDetail[0]['City'];?>" />
               <br/>
               
               <input type="text" class="required" name="txtZip" placeholder="Zipcode" value="<?php echo $arrUserDetail[0]['Zipcode'];?>" />
               <input type="text" class="required" value="<?php echo $arrUserDetail[0]['Contact_no'];?>" placeholder="What's your phone number?" name="Phone"/><br/>
               <br/>
               <?php if(file_exists("upload/user/".$arrUserDetail[0]['Photo']) && $arrUserDetail[0]['Photo']!=''):?>
                    <img width="100" height="100" src="upload/user/<?php echo $arrUserDetail[0]['Photo'];?>" />
                    <br/>
               <?php endif;?>
                    
               <input type="file" name="txtFile" placeholder="Upload Image" /><br/>
               <a class="various" href="#inline">Browse Skills</a>
               <div style="width: 500px; display: none;" id="inline">
                   <ul class="category">
                       <li><a data-attr="ALL" href="javascript://">All</a></li> 
                       <?php foreach($arrCategory as $intKey=>$strValue): ?>
                       <li><a data-attr="<?php echo $strValue['id'];?>" href="javascript://"><?php echo $strValue['name'];?></a></li> 
                       <?php endforeach;?>
                   </ul>
                   <ul class="skil">
                        <?php foreach($arrSkills as $intKey=>$strValue): ?>
                        <li class="cat_<?php echo $strValue['cat_id'];?> listskill">
                                <label>
                                    <input type="checkbox" name="skills[]" <?php if(in_array($strValue['sk_id'], $arrEditSkill)): echo 'checked'; endif;?> class="chk_sk" value="<?php echo $strValue['sk_id'];?>" />
                                <?php echo ucfirst($strValue['sk_name']);?>
                                </label>
                        </li>    
                        <?php endforeach;?>
                    </ul>
                </div>
               <input type="hidden" value="<?php echo $arrUserDetail[0]['Photo'];?>" name="hdnFile" /> 
               <p><input type="submit" name="btnEditPro" value="Save" /></p>
           </form>
                        </div></div>


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
    jQuery(document).ready(function(){
       jQuery(".category li a").click(function(){
            jQuery(".category li").removeClass("active");
            jQuery(this).parent("li").addClass("active");
            var intCat = jQuery(this).attr("data-attr");
            if(intCat=="ALL")
            {
                jQuery(".listskill").show();
            }
            else
            {
                jQuery(".listskill").hide();
                jQuery(".cat_"+intCat).show();
            }
       });
       jQuery(".chk_sk").click(function(){
           var intLength = $('input.chk_sk:checked').length;
           if(intLength>5)
           {
               jQuery(this).prop("checked",false);
           }
       });
    });
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