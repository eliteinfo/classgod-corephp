<?php
include 'lib/module.php';
if($_SESSION['clg_userid']=='')
{
    $objModule->redirect("./login.php");
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
        $(document).ready(function () {
            $("#faqs div.expand_title").toggler();
        });
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
<?php include("includes/header_top.inc.php"); ?>
<!----Top End---->
<!----header Start---->
<div class="header">
    <ul class="slides">
        <li>
            <div class="header_main">
                <div class="header_img"><img src="images/about_inner.jpg" alt=""></div>
                <div class="header_textbox">
                    <div class="wrapper">
                        <h1>Notification</h1>
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
            <?php
            if($_SESSION['clg_usertype']==0):
                include("includes/buyer_sidebar.inc.php");
            else:
                include 'includes/turor_lefbar.inc.php';
            endif;
            ?>

            <!----Sidebar end---->
            <div class="blog_part">
                <h2><span>Notifications</span></h2>
                <div id="noti_data">
                </div>
                <div id="paginate" class="navigation"></div>
                <br class="clear" /><br />
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
    $(window).load(function () {
    });
    function loadData(page)
    {
        $.ajax
        ({
            type: "GET",
            url: "ajax/notification.php?page=" + page,
            success: function (data)
            {
                var r = data.split('~^~^~');
                jQuery("#paginate").html(r[1]);
                jQuery("#noti_data").html(r[0]);
            }
        });
    }
    /*    function update_notification(nt_rd_id){
    	var noti_status = $("#noti_status_"+nt_rd_id).val();
    	$('#notification_chng_'+nt_rd_id).removeClass('new');
    	if(noti_status==0)
    	{
    		$.ajax
    		({
    			type: "GET",
    			url: "ajax/update_notification.php?nt_rd_id="+nt_rd_id,
    			success: function(data)
    			{
    				if(data != ""){
    					$("#noti_status_"+nt_rd_id).val(1);
    					$('.tot-noti').text(data);
    					$('#noti_total').text('('+data+')');
    					$('#noti_total2').text('('+data+')');
    				}
    			}
    		});
    	}

    }*/
    jQuery(document).ready(function()
    {
        loadData(1);
        $("#paginate").find('a').live('click',function(){
            var curr_page = $("#paginate").find('li.active').find('a').attr('p');
            var page = $(this).attr('p');
            if(curr_page!=page) {
                loadData(page);
            }
        });
    });
</script>