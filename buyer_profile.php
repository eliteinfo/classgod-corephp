<?php
include 'lib/module.php';
if ($_REQUEST['id'] != '')
{
    $intUserId = $_REQUEST['id'];
}
else if ($_SESSION['clg_userid'] != '' && $_SESSION['clg_usertype'] == 0)
{
    $intUserId = $_SESSION['clg_userid'];
}
else
{
    $objModule->redirect("./index.php");
}
$arrUserDetail = $objModule->getAll("SELECT tu.*,tc.Name AS cname,COUNT(tp.Id) AS pcnt FROM tbl_users tu 
                                        LEFT JOIN tbl_country tc ON tc.Id = tu.Country
                                        LEFT JOIN tbl_post tp ON tp.uid = tu.`Id` AND tp.`status` = '1'
                                    WHERE tu.Id = '".$intUserId."' AND tu.User_type = '0' GROUP BY tu.Id ");
if($arrUserDetail[0]['User_type']!='0')
{
    $objModule->redirect("./index.php");
}
$arrJobHistory = $objModule->getAll("select p.id,p.win_uid,p.title,b.Bid_amt,p.start_date_time,p.end_date,p.win_date from tbl_post p left join tbl_bidding b on p.id=b.Post_id where p.win_status='4' and p.uid=" . $intUserId. " GROUP BY p.`id` ORDER BY p.id desc ");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
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
                                <h1>Profile</h1>
                                <!--                                <div class="button_box2"> <a href="#">Post an assignment</a> </div>-->
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
                    <div class="sidebar">
                        <a class="category_top" href="#">Category</a>
                        <div class="category_box">
                            <div class="sidebar_box">
                                <div class="option_button">
                                    <a href="<?php echo $objModule->SITEURL; ?>addjob.php" class="option_button1">Post An Assignment</a>
                                </div>
                            </div>


                            <div class="sidebar_box">
                                <ul class="short_profile">
                                    <li>
                                        <?php 
                                            $intRate = 0.0;
                                            $arrRating = $objModule->getAll("SELECT AVG(review_rate) as avgrate FROM tbl_reviews WHERE review_to = '".$intUserId."'  "); 
                                           if($arrRating[0]['avgrate'] !='')$intRate = $arrRating[0]['avgrate'];
                                        ?>
                                        <div class="round_bg"><span><img src="images/icon16.png" alt="" /></span></div>
                                        <div class="amount_txt"><span><?php echo number_format((float)$intRate, 1, '.', '');?></span></div>
                                        <div class="small_txt">
                                            <span>
                                                <img src="images/gold_star/star_<?php echo $objModule->roundDownToHalf($intRate); ?>.png" alt="" />
                                            </span>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon18.png" alt="" /></span></div>
                                        <div class="amount_txt"><span><?php echo $arrUserDetail[0]['pcnt']; ?></span></div>
                                        <div class="small_txt"><span>job posted</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon20.png" alt="" /></span></div>
                                        <div class="amount_txt"><span><?php echo $arrUserDetail[0]['cname']; ?></span></div>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <div class="blog_found back_link"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back to search results</a></div>
                        <div class="blog_box">
                            <div class="tutors_people">
                                <?php if (file_exists("upload/user/" . $arrUserDetail[0]['Photo']) && $arrUserDetail[0]['Photo'] != ''): ?>
                                    <img src="upload/user/<?php echo $arrUserDetail[0]['Photo']; ?>" alt="" />
                                <?php else: ?>
                                    <img src="images/default.png" alt="" />
                                <?php endif; ?>
                            </div>

                            <div class="tutors_right">
                                <h2><a href="javascript://"><?php echo $arrUserDetail[0]['fname'] . ' ' . $arrUserDetail[0]['lname']; ?></a></h2>
                            </div>
                            <div class="profile_box">
                                <h3>Overview</h3>
                                <p> <?php echo stripcslashes($arrUserDetail[0]['description']); ?></p>
                            </div>
                            <div class="profile_box">
                                <h3>Work Examples/Credentials</h3>
                                <ul class="work_rating">
                                    <?php if (!empty($arrJobHistory)): ?>
                                        <?php
                                        foreach ($arrJobHistory as $intKey => $strValue):
                                            $arrReviewData = $objData->getAll("select review_desc,review_rate from tbl_reviews where review_post='" . $strValue['id'] . "' and review_to='" . $intUserId . "'");
                                            ?>
                                            <li>
                                                <ul>
                                                    <li>
                                                        <h4><?php echo $strValue['title'];?></h4>
                                                        <?php echo date('M Y',strtotime($strValue['win_date'])); ?> - <?php echo date('M Y',strtotime($strValue['end_date'])); ?><br />
                                                        Fixed Price $<?php echo $strValue['Bid_amt']; ?><br />
                                                    </li>
                                                    <?php if(count($arrReviewData)>0):?>
                                                        <li><?php echo $arrReviewData[0]['review_desc']; ?></li>
                                                        <li><?php echo number_format((float)$arrReviewData[0]['review_rate'], 1, '.', '');?><span class="rating"><img src="images/gold_star/star_<?php echo $objModule->roundDownToHalf($arrReviewData[0]['review_rate']); ?>.png" alt="" /></span></li>
                                                    <?php else:?>
                                                        <li>No review given yet</li>
                                                        <li>No ratings given yet</li>
                                                        <li>&nbsp;</li>
                                                    <?php endif;?>
                                                </ul>
                                            </li>

                                        <?php endforeach; ?>    
                                    <?php else: ?>
                                    <li><h3>No Job completed Yet</h3></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
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