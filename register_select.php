<?php 

include 'lib/module.php';

if($_POST['btnSubmit']!='')

{

    if($_POST['rdbType']==0)

    {

        //for buyer register redirect

        $objModule->redirect("./buyer.php");

    }   

    else

    {

        $objModule->redirect("./contractor.php");

        //for freelancer register redirect

    }

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God : Signup select</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
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
            <h1>Create An Account</h1>
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
<form method="POST" id="frmRegister" name="frmRegister">
          <h2 align="center" class="title2">Hello and welcome to ClassGod! Already have an account? <a href="<?php $objModule->SITEURL; ?>login.php">Sign In</a></h2>
          <div id="employer-provider-signup" class="creat_acct signup_acct">
    <div class="one_half">
              <input type="radio"  value="0" id="hire-account" checked="" tabindex="1" name="rdbType" /><br />
              <label for="hire-account">I want to <strong>Hire</strong><br>
        <span>Instant access to the world's top pool of rated freelancers.</span> </label>
            </div>
    <div class="one_half">
              <input type="radio"  id="work-account" value="1" name="rdbType" /><br />
              <label for="work-account">I want to <strong>Work</strong><br>
        <span>Find clients, get hired, get paid.</span> </label>
            </div>
    <div class="clear"></div>
    <input type="submit" name="btnSubmit" value="Continue" />
  </div>
</form>
</div>
    <!----content End----> 
  </div>
</div>
<!----mid End----> 
<!----Footer Start---->
<?php include('includes/footer.inc.php'); ?>
</body>
</html>
