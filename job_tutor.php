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
$strBidPost = "SELECT tp.*,tb.create_at FROM 
                    tbl_bidding tb 
                     INNER JOIN tbl_post tp ON tp.id = tb.Post_id
                     INNER JOIN tbl_users tu ON tu.Id = tb.Uid 
                    WHERE tu.Id = '".$_SESSION['clg_userid']."' AND tp.win_status = '0'
                    GROUP BY tp.id ORDER BY tp.id DESC";
$arrBidPost = $objModule->getAll($strBidPost);

$arrTempSkills  =   $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");
foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
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
                                <h1>Add Skills</h1>
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
                                <h2><span>Profile</span></h2>
                                <ul>
                                    <li><a href="tutors_profile.php">Overview</a></li>
                                    <li><a href="job_tutor.php">Job History</a></li>
                                    <li><a href="edit_skills.php">Skills</a></li>
                                    <li><a href="edit_contractor.php">Contact Info</a></li>
                                    <li><a href="#">Review</a></li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <ul class="short_profile">
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon16.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>5.00</span></div>
                                        <div class="small_txt"><span><img src="images/icon15.png" alt="" /></span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon17.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>$99.66</span></div>
                                        <div class="small_txt"><span>Hourly Rate</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon18.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>15</span></div>
                                        <div class="small_txt"><span>Total Job Worked</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon19.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>2,339</span></div>
                                        <div class="small_txt"><span>Total Hours</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon20.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>Croatia</span></div>
                                        <div class="small_txt"><span>Opatija</span></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <h2><span>Groups</span></h2>
                                <ul>
                                    <li><a href="#">Group A</a></li>
                                    <li><a href="#">Group B</a></li>
                                    <li><a href="#">Group C</a></li>
                                    <li><a href="#">Group D</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <?php $strCur = date("Y-m-d H:i:s"); ?>
                        <?php if(!empty($arrBidPost)): 
                        foreach ($arrBidPost as $intKey => $strValue): ?>
                            <div class="blog_box">
                                <div class="blog_fullbox">
                                    <div class="blog_titel">
                                        <h2><a href="#"><?php echo $strValue['title']; ?></a></h2>
                                    </div>
                                    <div class="blog_price">
                                        <ul>
                                            <li class="active"><a href="#">Fixed Price</a></li>
                                            <li><a href="#">Est. Budget</a></li>
                                            <li>$<a href="#"><span class="money"><?php echo $strValue['price']; ?></span></a></li>
                                        </ul>
                                        <span class="blog_time">You send proposal on
                                            <?php echo $objModule->timeDiff($strValue['create_at'], $strCur); ?>
                                        </span> 
                                    </div>
                                </div>
                                <?php if($strValue['skills']!=''):?>
                                    <?php 
                                    $arrS = array();
                                    $arrS = @explode(',',$strValue['skills']);
                                    ?>
                                        <div class="blog_tag">
                                            <?php foreach($arrS as $intS=>$strS):?>
                                            <a href="#"><?php echo ucfirst($arrSkill[$strS]);?></a>
                                            <?php endforeach;?>
                                        </div>
                                <?php endif;?>
                                <div class="blog_text">
                                    <p>
                                        <?php if(strlen($strValue['description'])<300):
                                                echo $strValue['description'];
                                              else:
                                                echo $strValue['description'].'....';  
                                              endif;  
                                        ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                                    endforeach;
                        else:
                            $arrJobs    =   $objModule->getAll("SELECT * FROM tbl_post WHERE status='1' and win_status='0' AND end_date_time > now() GROUP BY id ORDER BY id DESC");
                        foreach ($arrJobs as $intKey => $strValue): ?>
                            <div class="blog_box">
                                <div class="blog_fullbox">
                                    <div class="blog_titel">
                                        <h2><a href="#"><?php echo $strValue['title']; ?></a></h2>
                                    </div>
                                    <div class="blog_price">
                                        <ul>
                                            <li class="active"><a href="#">Fixed Price</a></li>
                                            <li><a href="#">Est. Budget</a></li>
                                            <li>$<a href="#"><span class="money"><?php echo $strValue['price']; ?></span></a></li>
                                        </ul>
                                        <span class="blog_time">Posted
                                            <?php echo $objModule->timeDiff($strValue['created_date'], $strCur); ?>
                                        </span> 
                                    </div>
                                </div>
                                <?php if($strValue['skills']!=''):?>
                                    <?php 
                                    $arrS = array();
                                    $arrS = @explode(',',$strValue['skills']);
                                    ?>
                                        <div class="blog_tag">
                                            <?php foreach($arrS as $intS=>$strS):?>
                                            <a href="#"><?php echo ucfirst($arrSkill[$strS]);?></a>
                                            <?php endforeach;?>
                                        </div>
                                <?php endif;?>
                                <div class="blog_text">
                                    <p>
                                        <?php if(strlen($strValue['description'])<300):
                                                echo $strValue['description'];
                                              else:
                                                echo $strValue['description'].'....';  
                                              endif;  
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <a href="detail.php?pid=<?php echo $strValue['id'];?>">Apply</a>
                                </div>    
                            </div>
                        <?php endforeach; ?>
                        <?php endif;?>
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
<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery(".category li a").click(function(){
            //jQuery(".category li").removeClass("active");
            //alert(jQuery(this).parent("li").attr("class"));
            var intCat = jQuery(this).attr("data-attr");
            if(intCat=="ALL")
            {
                jQuery(".listskill").show();
            }
            else
            {
                jQuery(".listskill").hide();
                jQuery(".cat_"+intCat).show();
            }
       });
       jQuery(".chk_sk").click(function(){
           var intLength = $('input.chk_sk:checked').length;
           if(intLength>5)
           {
               jQuery(this).prop("checked",false);
           }
       });
    });
</script>