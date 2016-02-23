<?php
include 'lib/module.php';
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
                        <h1>Bid Submited</h1>
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
            <h2 align="center" style="color:#ed1c24;">Thank you! </h2>
            <div class="creat_acct">
                Your Bid has been submited, you will get notification if you are selected,
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