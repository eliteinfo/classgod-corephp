<?php
include 'lib/module.php';
if($_GET['intVerify']==1)
{
    $objModule->setMessage("Please verify your email","error");
}
if($_POST['btnLogin']!='')
{
    if($_POST['txtUemail']!='' && $_POST['txtPassword']!='')
    {
        $arrExist = $objModule->getAll("SELECT * FROM tbl_users WHERE (Username = '".$_POST['txtUemail']."' OR Email = '".$_POST['txtUemail']."') AND Password = '".md5($_POST['txtPassword'])."'  ");
        if(!empty($arrExist))
        {
            //echo "<pre>";print_r($arrExist);die;
            $_SESSION['clg_userid']     = $arrExist[0]['Id'];
            $_SESSION['clg_usertype']   = $arrExist[0]['User_type'];
            $_SESSION['classgod_User']=$arrExist;
            if($arrExist[0]['Status']==0 && $arrExist[0]['scrtyq']==1)
            {
                session_destroy();
                $objModule->redirect("./login.php?intVerify=1");
            }
            else if($arrExist[0]['Status']==0 && $arrExist[0]['scrtyq']==0)
            {
                $objModule->redirect("./security.php");
            }
            else
            {
                if($_SESSION['clg_usertype']==0)
                {
                    // for buyer
                    $objModule->redirect("./dashboard-buyer.php");
                }
                else
                {
                    // for tutor
                    $objModule->redirect("./tutordashboard.php");
                }
               
            }
        }
        else
        {
            $objModule->setMessage("Invalid username/email or password","error");
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
            <h1>Login</h1>
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
<h2 class="title2" align="center"><span>Login</span> to your account</h2>
<div class="creat_acct login_acct">
            <?php echo $objModule->getMessage();?>
    <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)">
                <input type="text" name="txtUemail" class="required" placeholder="Username *" /><br/>
                <input type="password" name="txtPassword" id="txtEmail" class="required " placeholder="Password *" /><br/>
                <div class="frgt_row"><a href="<?php echo $objModule->SITEURL;?>forgotpass.php">Forgot password?</a></div>
                <input type="hidden" name="hdnUrl" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />
                <input type="submit" name="btnLogin" value="Login" />
            </form> 
            <div class="clear"></div>
</div>
<div align="center" class="regacc_row"><a href="<?php echo $objModule->SITEURL;?>register_select.php">Create an account</a></div>
</div>
    <!----content End----> 
  </div>
</div>
<!----mid End----> 
<!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?>
    </body>
</html>