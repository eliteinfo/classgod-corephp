<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
$arrUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' ");

if ($_POST['btnRegister'] != '')
{
    
    
    if($_POST['security1']!='' && $_POST['security2']!='' && $_POST['answer1']!='' && $_POST['answer2']!='')
    {
        $objData =  new PCGData();
        $objData->setTableDetails("tbl_users","Id");
        $objData->setFieldValues("sques1",$_POST['security1']);
        $objData->setFieldValues("sques2",$_POST['security2']);
        $objData->setFieldValues("ans1",$_POST['answer1']);
        $objData->setFieldValues("ans2",$_POST['answer2']);
        $objData->setFieldValues("university",$_POST['uni']);
        $objData->setFieldValues("grade",$_POST['grade']);
        $objData->setFieldValues("scrtyq",'1');
        $objData->setWhere("Id = '".$_SESSION['clg_userid']."' ");
        $objData->update();
        unset($objData);
        if($arrUser[0]['Status']==0)
        {
            session_destroy();
            $objModule->redirect("./login.php?intVerify=1");
        }
        else
        {
            if($arrUser[0]['User_type']==0)
            {
                /*for buyer*/
                $objModule->redirect("./addjob.php");
            }
            else
            {
                /* for tutor*/
                $objModule->redirect("./edit_tutor_profile.php");
            }
        }
    }
    else
    {
        $objModule->setMessage("Please filled the required fields","error");
    }
}
$arrCountry = $objModule->getAll("SELECT * FROM tbl_country ORDER BY Name asc");
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
           <h1>Add security question</h1>
         </div>
       </div>
     </div>
   </li>
 </ul>
</div>
<div class="mid">
    <div class="wrapper"> 
        <div class="content_part">
            <div class="regform">
            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)">
            	<div class="row">
                	<div class="one_full"><select id="security_question1" name="security1" class="required">
                            <option value="">- Select -</option>
                            <option value="What city was your mother born in?">What city was your mother born in?</option>
                            <option value="What's the name of the street you grew up on?">What's the name of the street you grew up on?</option>
                            <option value="What's the name of your first boyfriend or girlfriend?">What's the name of your first boyfriend or girlfriend?</option>
                            <option value="What's the name of the high school you attended?">What's the name of the high school you attended?</option>
                            <option value="What's the name of your first pet?">What's the name of your first pet?</option>
                        </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><input type="text" name="answer1" placeholder="Answer of Question1" class="required" /></div>
                </div>
                <div class="row">
                	<div class="one_full"><select name="security2" class="required">
                                <option value="">- Select -</option>
                                <option value="What city was your father born in?">What city was your father born in?</option>
                                <option value="What city did you grow up in?">What city did you grow up in?</option>
                                <option value="What's the name of your best childhood friend?">What's the name of your best childhood friend?</option>
                                <option value="What's the name of the elementary school you attended?">What's the name of the elementary school you attended?</option>
                                <option value="What's your favorite book?">What's your favorite book?</option>
                            </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><input type="text" name="answer2" placeholder="Answer of Question1" class="required" /></div>
                </div>
                <div class="row">
                	<div class="one_full"><input type="text" placeholder="what university/school do you attend?" name="uni" /></div>
                </div>
                <div class="row">
                	<div class="one_full"><input type="text" placeholder="what grade in school are you in?" name="grade" /></div>
                </div>
                <div class="row">
                	<div class="one_full"><input type="submit" name="btnRegister" value="Continue" /></div>
                </div>
                    </form> 
            </div>
        </div>
    </div>    
</div>
<!----mid End---->
<!----Footer Start---->
<?php include('includes/footer.inc.php');?>
</body>
</html> 