<?php
include 'lib/module.php';
include("lib/simpleimage.php");
if($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
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
        $objData->setFieldValues("Password",md5($_POST['txtPassword']));
    endif;
    if($_FILES['txtFile']['name']!='')
    {
	   $allowed =  array('gif','png' ,'jpg', 'jpeg'); 
	   $filename_chk = $_FILES['txtFile']['name'];
       $strEx = pathinfo($filename_chk,PATHINFO_EXTENSION);
       if(!in_array($strEx,$allowed))
	   {
		  $objModule->setMessage("Not valid image", "Error");
	   }
	   else
	   {
		    $strFilename = uniqid().".".$strEx;
			$imageInformation = getimagesize($_FILES['txtFile']['tmp_name']);
            $width = $imageInformation[0];
            $height = $imageInformation[1];
			if(move_uploaded_file($_FILES['txtFile']['tmp_name'],"upload/user/".$strFilename))
			{
				 list($width, $height, $type, $attr) = getimagesize("upload/user/".$strFilename);	
				 if($width > 100 || $height > 100){                               
                        $objImg = new SimpleImage();
                        $objImg->load("upload/user/".$strFilename);
                        $objImg->resize(100,100);
                        $objImg->save("upload/user/".$strFilename);
                    }else{
                        $objImg = new SimpleImage();
                        $objImg->load("upload/user/".$strFilename);
                        $objImg->save("upload/user/".$strFilename);
                    }	
					if($_POST['hdnFile']!='')
       				{
           				$strDel = "upload/user/".$_POST['hdnFile'];
           				unlink($strDel);
       				}	
					unset($objImg);
					$objData->setFieldValues("Photo", $strFilename);							
  			}
			else
			{
				 $objData->setFieldValues("Photo","userpic.png");	
				
			}
	   }	   
    }
    $objData->setWhere("Id = '".$_SESSION['clg_userid']."' ");
    $objData->update();	
    unset($objData);
    $objModule->redirect("./dashboard-buyer.php");
}
$arrUserDetail = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' AND User_type = '0' ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.classyedit.css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script src="js/jquery.classyedit.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
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
        <script>
            $(document).ready(function () {
                $("#faqs div.expand_title").toggler();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#ca_prob").ClassyEdit();
                $(".category_top").click(function () {
                    $(".category_box").slideToggle(400);
                    return false;
                });
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
                        <div class="header_img"><img src="images/about_inner.jpg" alt=""></div>
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
                    <!----Sidebar Start---->
                    <?php include("includes/buyer_sidebar.inc.php"); ?>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><span>Edit Profile</span></h2>
                        <div class="regform mrgtop0">
						<label>
						<a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your Account?')">Delete Account</a>
						</label>
                            <form method="POST" id="frmRegister" name="frmRegister" enctype="multipart/form-data" onsubmit="return frmvalidate(this.id)">
               <input type="text" name="txtFName" value="<?php echo $arrUserDetail[0]['fname'];?>" class="required" placeholder="First Name *" /><br/><br/>
               <input type="text" name="txtLName" class="required" value="<?php echo $arrUserDetail[0]['lname'];?>" placeholder="Last Name *" /><br/><br/>
               <input type="password" name="txtPassword" class="password" placeholder="Password" />
               <div id="userchk"> <span style="font-size:11px;color:#f00">Leave blank in case of no change</span> </div>
               <br>
               <input type="text" name="txtUniversity" id="txtUni" placeholder="Enter the university name" class="" style="display: none;"/>
               <textarea name="txtDescription" id="ca_prob" rows="5"><?php echo stripslashes($arrUserDetail[0]['description']);?></textarea>
               <br/>
               <select name="cmbCountry" id="cmbCountry" class="required">
                    <option value="">Select Country</option>
                    <?php foreach ($arrCountry as $strCounty): ?>
                        <option value="<?php echo $strCounty['Id']; ?>" <?php if ($strCounty['Id'] == $arrUserDetail[0]['Country']): echo 'selected';
                    endif; ?>><?php echo $strCounty['Name']; ?></option>
                   <?php endforeach; ?>    
                </select>
               <br/><br/>
               <input type="text" name="txtState" class="required" placeholder="State" value="<?php echo $arrUserDetail[0]['State'];?>" /><br /><br />
               <input type="text" name="txtCity" placeholder="City" class="required" value="<?php echo $arrUserDetail[0]['City'];?>" />
               <br/><br/>
               <input type="text" name="txtZip" class="required" placeholder="Zipcode" value="<?php echo $arrUserDetail[0]['Zipcode'];?>" /><br /><br />
               <input type="text" class="required onlynumber" placeholder="What's your phone number?" value="<?php echo $arrUserDetail[0]['Contact_no']; ?>" name="Phone"/><br/><br />
               <br/>
               <?php if(file_exists("upload/user/".$arrUserDetail[0]['Photo']) && $arrUserDetail[0]['Photo']!=''):?>
                    <img width="100" height="100" src="upload/user/<?php echo $arrUserDetail[0]['Photo'];?>" />
                    <br/><br />
               <?php endif;?>
               <input type="file" name="txtFile" placeholder="Upload Image" /><br/><br />
               <input type="hidden" value="<?php echo $arrUserDetail[0]['Photo'];?>" name="hdnFile" /> 
               <p><input type="submit" name="btnEditPro" value="Save" /></p>
           </form>
                                        </div>
                                        </div>
                                        <div class="regacc_row" align="center"></div>
                                        </div>
                                        <!----content End---->
                                        </div>
                                        </div>
                                        <!----mid End---->
                                        <!----Footer Start---->
                                        <?php
                                        include("includes/footer.inc.php");
                                        ?>
                                        </body>
                                        </html>
                                        <script type="text/javascript">
                                            function chkDisplay(strFname, strLname, strObj)
                                            {
                                                if (jQuery("#showInitialOnly").prop("checked") == true)
                                                {
                                                    var strInitital = strLname.charAt(0);
                                                    var strName = strFname + ' ' + strInitital;
                                                }
                                                else
                                                {
                                                    var strName = strFname + ' ' + strLname;
                                                }
                                                jQuery("#txtDisplay").val(strName);
                                            }
                                        </script>