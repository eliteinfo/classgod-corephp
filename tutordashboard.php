<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 0)
{
    // redirect to tutor dashboard
    $objModule->redirect("./dashboard-buyer.php");
}
$arrUserDetail = $objModule->getAll("SELECT * FROM tbl_users where Id = '".$_SESSION['clg_userid']."' AND User_type = '1'");
$totalamnt = $objModule->getAll("SELECT SUM(amount) AS total FROM tbl_tutor_pay where uid = '".$_SESSION['clg_userid']."'");
$amnt = sprintf ("%.2f", $totalamnt[0]['total']);
if($amnt!='' AND $amnt!='0.00'){
	$tamount=$amnt;
}
else{
	$tamount='N/A';
}



if(empty($arrUserDetail))
{
    $objModule->redirect("./index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Class God</title>
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/expand.js"></script>
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
        /*$(document).ready(function () {
            $("#faqs div.expand_title").toggler();
        });*/
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
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
                        <h1>My Account</h1>
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
        <?php echo $objModule->getMessage();?>
        <!----content Start---->
        <div class="content_part">
            <!----Sidebar Start---->
            <?php include 'includes/turor_lefbar.inc.php';?>
            <!----Sidebar end---->
            <div class="blog_part">
                <div class="hrsrate">
                    <!--                            <h2>My hourly Rate: <input type="text"  value="$99"></h2>-->
                    <h2>Total site earnings: $ <?php echo $tamount; ?></h2>
                </div>
                <h2><span>Active Jobs</span></h2>
                <div id="job_won"></div>
                <div id="paginate_won" class="navigation"></div>
                <br  class="clear" />
                <h2 style="margin-top:20px;"><span>Jobs Bidded</span></h2>
                <div id="job_bidded"></div>
                <div id="paginate" class="navigation"></div>
            </div>
            <div class="regacc_row" align="center"></div>
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
    function loadData(page)
    {
        $.ajax
        ({
            type: "GET",
            url: "ajax/jobbidden_bidded.php?page="+page,
            success: function(data)
            {
                var r = data.split('~^~^~');
                jQuery("#paginate").html(r[1]);
                jQuery("#job_bidded").html(r[0]);
            }
        });
    }
    function loadData_won(page_won)
    {
        $.ajax
        ({
            type: "GET",
            url: "ajax/jobbidden_won.php?page="+page_won,
            success: function(data_won)
            {
                var h = data_won.split('~^~^~');
                jQuery("#paginate_won").html(h[1]);
                jQuery("#job_won").html(h[0]);
            }
        });
    }
    jQuery(document).ready(function(){
        loadData(1);
        $("#paginate").find('a').live('click',function(){
            var curr_page = $("#paginate").find('li.active').find('a').attr('p');
            var page = $(this).attr('p');
            if(curr_page!=page) { loadData(page); }
        });
        loadData_won(1);
        $("#paginate_won").find('a').live('click',function(){
            var curr_page = $("#paginate_won").find('li.active').find('a').attr('p');
            var page_won = $(this).attr('p');
            if(curr_page!=page_won) { loadData_won(page_won);}
        });
    });
</script>