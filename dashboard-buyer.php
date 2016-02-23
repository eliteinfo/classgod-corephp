<?php
include("lib/module.php");
include 'lib/Pagination.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
$intNum = 10;
$intStart = ($objModule->getRequest("pagination-page", "") != '') ? ($intNum * $objModule->getRequest("pagination-page", "") - $intNum) : 0;
$strTable = "`tbl_post` tp
                                    LEFT JOIN `tbl_bidding` tb ON tb.`Post_id` = tp.`id`  ";
$strWhere = " tp.uid = '" . $_SESSION['clg_userid'] . "' AND tp.status = '1' AND tp.win_status !='4' ";
$strGroup = "tp.`id`";
$strOrder = "tp.`id` DESC";
$arrJobs = $objModule->getAll($strTable, array("tp.*", "COUNT(tb.id) AS bidders"), $strWhere, $strGroup, $strOrder, $intStart, $intNum);

$intTotal   = $objModule->intTotalRows;
$objPagination = new Pagination($intTotal,MAX_PAGE_NUMBER_PER_SECTION,$intNum);
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


        <!----Top Start---->
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
                <!----content Start---->
                <?php echo $objModule->getMessage();?>
                <div class="content_part">
                    <!----Sidebar Start---->
                    <?php include("includes/buyer_sidebar.inc.php"); ?>
                    <!----Sidebar end---->
                    <div class="blog_part asmt_history">
                        <h2><span>Your Assignments</span></h2>
                        <?php if (!empty($arrJobs)): ?>
                            <?php foreach($arrJobs as $intKey=>$strValue):?>
                                <div class="blog_fullbox blog_fullbox_sml">
                                    <div class="blog_text_sml">
                                        <h3><a href="job_detail.php?post_id=<?php echo $strValue['id'];?>&post_uid=<?php echo $strValue['uid'];?>"><?php echo $strValue['title'];?></a></h3>
                                        <p><?php echo $objModule->getShortDescription($strValue['description']);?></p>
                                    </div>
                                    <div class="blog_price blog_price_sml">
                                        <ul>
                                            <li class="active">Project Budget</li>
                                            <li>$<span class="money"><?php echo ($strValue['price']!='')?$strValue['price']:"N/A";?></span></li>
                                        </ul>
                                        <span class="blog_time">Posted: <?php echo date("M d Y",  strtotime($strValue['created_date']));?></span> <br />
                                        <span class="viewbid-txt">
                                            <?php if($strValue['bidders']>0):?>
                                                <a href="viewbidders.php?post_id=<?php echo $strValue['id'];?>">View Bidders (<?php echo $strValue['bidders'];?>)</a>
                                                <br/>
                                                <?php if($strValue['win_status']==1 && $strValue['win_uid']!=''): ?>
                                                <a href="buyer-milestone.php?post_id=<?php echo $strValue['id'];?>&post_uid=<?php echo $strValue['uid'];?>">View Milestone</a>
                                                <?php endif;?>
                                            <?php else:?>
                                                <a href="javascript://">View Bidders (<?php echo $strValue['bidders'];?>)</a>
                                            <?php endif;?>
                                        </span><br />
                                        <span class="blog_time">Status: <span style="color:<?php echo $objModule->arrWinStatusColor[$strValue['win_status']];?>"><?php echo $objModule->arrWinStatus[$strValue['win_status']];?></span></span>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php else: ?>        
                            <div class="blog_fullbox blog_fullbox_sml">
                                <div class="blog_text_sml">
                                    <h3>No Assignment found.</h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($intTotal>$intNum): ?>
                        <div class="navigation">
                            <?php echo $objPagination->display().$objPagination->displaySelectInterface(); ?>
                        </div>
                        <?php endif;?>
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