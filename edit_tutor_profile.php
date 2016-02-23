<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 0)
{
    // redirect to tutor dashboard
    $objModule->redirect("./buydashboard.php");
}
$arrCategory = $objModule->getCategory();
$arrCountry = $objModule->getCountry();
$arrSkills = $objModule->getAll("SELECT tss.* FROM tbl_skills tss ORDER BY sk_id ASC");
if ($_POST['btnEditPro']!='')
{
    $objData = new PCGData();
    $objData->setTableDetails("tbl_users", "Id");
    $objData->setFieldValues("fname", $_POST['txtFName']);
    $objData->setFieldValues("lname", $_POST['txtLName']);
    $objData->setFieldValues("description", $_POST['txtDescription']);
    $objData->setFieldValues("State", $_POST['txtState']);
    $objData->setFieldValues("City", $_POST['txtCity']);
    $objData->setFieldValues("Zipcode", $_POST['txtZip']);
    $objData->setFieldValues("Country", $_POST['cmbCountry']);
    $objData->setFieldValues("disp_name", $_POST['txtDisplay']);
    $objData->setFieldValues("Contact_no", $_POST['Phone']);
    $objData->setFieldValues("h_rate", $_POST['txtRate']);
    $objData->setFieldValues("paypal", $_POST['txtPaypal']);

    if ($_POST['showInitialOnly'] == 1)
    {
        $objData->setFieldValues("dis_status", '1');
    }
    if ($_POST['txtPassword'] != ''):
        $objData->setFieldValues("Password", md5($_POST['txtPassword']));
    endif;
    if ($_FILES['txtFile']['name'] != '')
    {
        $strEx = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
        $strFilename = uniqid() . "." . $strEx;
        move_uploaded_file($_FILES['txtFile']['tmp_name'], "upload/user/" . $strFilename);
        $objData->setFieldValues("Photo", $strFilename);
        if ($_POST['hdnFile'] != '')
        {
            $strDel = "upload/user/" . $_POST['hdnFile'];
            unlink($strDel);
        }
    }
    $objData->setWhere("Id = '" . $_SESSION['clg_userid'] . "' ");
    $objData->update();
    //echo "<pre>";print_r($objData->getSQL());die;
    unset($objData);
    $objModule->redirect("./edit_tutor_profile.php");
}
$arrUserDetail = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '" . $_SESSION['clg_userid'] . "' AND User_type = '1' ");
$arrEditSkill = array();
if ($arrUserDetail[0]['skills'] != '')
{
    $arrEditSkill = @explode(',', $arrUserDetail[0]['skills']);
}
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
                    <?php include 'includes/turor_lefbar.inc.php'; ?>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><span>Edit Profile</span></h2>
                        <div class="regform">
						<label>
						<a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your Account?')">Delete Account</a>
						</label>
                            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id);" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="one_half">
                                        <input  value="<?php echo $arrUserDetail[0]['fname']; ?>" name="txtFName" id="txtFName" class="required" onblur="chkDisplay(document.getElementById('txtFName').value, document.getElementById('txtLName').value, '');" placeholder="Firstname" type="text">
                                    </div>
                                    <div class="one_half last">
                                        <input  value="<?php echo $arrUserDetail[0]['lname']; ?>" name="txtLName" id="txtLName" class="required" placeholder="Lastname" type="text" onblur="chkDisplay(document.getElementById('txtFName').value, document.getElementById('txtLName').value, '');" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <input  readonly  value="<?php echo $arrUserDetail[0]['Email']; ?>"  name="txtEmail" id="txtEmail" class="required email" placeholder="Email"  type="text" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="last">
                                      <input kl_virtual_keyboard_secure_input="on" name="txtPaypal" value="<?php echo $arrUserDetail[0]['paypal']; ?>"  placeholder="Paypal Id" class="email" type="text">
                                    </div>
                                    <div id="userchk"> <span style="font-size:11px;color:#f00">Your paypal email account.</span> </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <input  value="<?php echo $arrUserDetail[0]['Username']; ?>" readonly name="txtUsername" id="txtUsername" class="uname required" placeholder="Username" type="text">
                                        <!--<div id="userchk" style="display: none;"><span style="font-size:11px;color:#f00">Username exists, please try a different username.</span></div>--> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="last">
                                        <input kl_virtual_keyboard_secure_input="on" name="txtPassword"  placeholder="Password" type="password">
                                    </div>
                                    <div id="userchk"> <span style="font-size:11px;color:#f00">Leave blank in case of no change</span> </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <input kl_virtual_keyboard_secure_input="on" name="txtDisplay" id="txtDisplay" class="required"  placeholder="Display name" value="<?php echo $arrUserDetail[0]['disp_name']; ?>" type="text">
                                    </div>
                                    <div class="one_full last chkrad">
                                        <label class="lblbtm">
                                            <input value="1" onchange="chkDisplay(document.getElementById('txtFName').value, document.getElementById('txtLName').value, this)" <?php
                                            if ($arrUserDetail[0]['dis_status'] == 1): echo 'checked';
                                            endif;
                                            ?> id="showInitialOnly" name="showInitialOnly" type="checkbox" />
                                            Display last initial only.</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <input class="required onlynumber" type="text" placeholder="Hourly rate *" value="<?php echo $arrUserDetail[0]['h_rate']; ?>" name="txtRate" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
									
                                        <?php
										$categories=explode(',',$arrUserDetail[0]['cat_id']);
										for($i=0;$i<count($categories);$i++){
                                        $cat = $objData->getAll("select * from tbl_category where id='" . $categories[$i] . "'");
										$cat_name[]=$cat[0]['name'];
										}
										$final_name=implode(', ',$cat_name);
                                        ?>
                                        <input  name="txtCategory" id="txtCategory" class="required" placeholder="Category" value="<?php echo $final_name; ?>" type="text" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <label>Select Country</label>
                                        <select name="cmbCountry" id="cmbCountry" class="required">
                                            <option value="">Select Country</option>
                                            <?php foreach ($arrCountry as $strCounty): ?>
                                                <option value="<?php echo $strCounty['Id']; ?>" <?php
                                                if ($strCounty['Id'] == $arrUserDetail[0]['Country']): echo 'selected';
                                                endif;
                                                ?>><?php echo $strCounty['Name']; ?></option>
                                                    <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_half">
                                        <input  value="<?php echo $arrUserDetail[0]['State']; ?>" name="txtState" class="required"  type="text">
                                    </div>
                                    <div class="one_half last">
                                        <input class="required" type="text" value="<?php echo $arrUserDetail[0]['City']; ?>" placeholder="City" name="txtCity">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_half">
                                        <input class="required"  value="<?php echo $arrUserDetail[0]['Zipcode']; ?>"  placeholder="Zipcode" name="txtZip" type="text" />
                                    </div>
                                    <div class="one_half last">
                                        <input class="required" type="text" value="<?php echo $arrUserDetail[0]['Contact_no']; ?>" name="Phone" placeholder="What's your phone number?" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="one_full">
                                        <label>Upload Profile Picture</label>
                                        <?php if (file_exists("upload/user/" . $arrUserDetail[0]['Photo']) && $arrUserDetail[0]['Photo'] != ''): ?>
                                            <img width="100" height="100" src="upload/user/<?php echo $arrUserDetail[0]['Photo']; ?>" /> <br/>
                                        <?php endif; ?>
                                        <input type="file" name="txtFile" placeholder="Upload Image" />
                                        <br/>
                                    </div>
                                </div>
                                <br>
                                    <div class="row">
                                        <div class="one_full">
                                            <label>About me</label>
                                            <!--<img src="images/texteditor-img.jpg" />-->
                                            <textarea name="txtDescription" id="ca_prob" class="required" rows="5" placeholder="About me"><?php echo stripslashes($arrUserDetail[0]['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <br>
                                        <div class="row sbmt">
                                            <input type="hidden" value="<?php echo $arrUserDetail[0]['Photo']; ?>" name="hdnFile" />
                                            <div class="one_full">
                                                <input name="btnEditPro" value="Continue" type="submit" />
                                            </div>
                                        </div>
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