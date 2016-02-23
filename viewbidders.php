<?php
include 'lib/module.php';
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
$arrPost = $objModule->getAll("SELECT title,win_status FROM tbl_post WHERE id = '" . $_GET['post_id'] . "' ");
$intNum = MAX_RECORD_PER_PAGE;
$intStart = ($objModule->getRequest("pagination-page", "") != '') ? ($intNum * $objModule->getRequest("pagination-page", "") - $intNum) : 0;
$strTable = "`tbl_bidding` tb
		INNER JOIN `tbl_post` tp ON  tb.`Post_id` = tp.`id`
		INNER JOIN tbl_users tu ON tu.`Id` = tb.`Uid`
                LEFT JOIN tbl_country tc ON tc.Id = tu.Country ";
$strCond = "tb.`Post_id` = '" . $_GET['post_id'] . "'   ";
$strGroupby = "tu.`Id`";
$arrBidders = $objModule->getAll($strTable, array("tu.*","tp.win_status","tb.status as bid_status","tb.Uid as bider_id","tb.Id as bid_id","tb.Bid_amt","tb.Description","tc.Name as cname","tu.State","tb.delivery_date"), $strCond, $strGroupby, "tb.`create_at` DESC", $intStart, $intNum);
$intTotal = $objModule->intTotalRows;
$objPagination = new Pagination($intTotal, MAX_PAGE_NUMBER_PER_SECTION, $intNum);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.js"></script> 
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
        <script type="text/javascript">
            $(document).ready(function () {
                $(".category_top").click(function () {
                    $(".category_box").slideToggle(400);
                    return false;
                });
            });
        </script>
        <script type="text/javascript">
              $(document).ready(function () {
  $('.sug_skil').on("click", function (e) {
    e.preventDefault(); // avoids calling preview.php
    $.ajax({
      type: "POST",
      cache: false,
      url: this.href, // preview.php
      data: {CMD:"GET_BIDCONTENT",bid_id:$(this).attr("data-attr")}, // all form fields
      success: function (data) 
      {
        // on success, post (preview) returned data in fancybox
        $.fancybox(data, {
          // fancybox API options
            maxWidth	: 800,
            maxHeight	: 600,
            autoResize : true,
			fitToView : true,
            width	: '70%',
            height	: '70%',
            autoSize	: true,
            closeClick	: false,
            openEffect	: 'none',
            closeEffect	: 'none'
        }); // fancybox
      } // success
    }); // ajax
  }); // on
}); // ready  
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
                <div class="content_part"> 
                    <!----Sidebar Start---->
                    <?php include("includes/buyer_sidebar.inc.php"); ?>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><span class="hleft">Bidders for:</span> <span class="hright">&quot;<?php echo $arrPost[0]['title']; ?>&quot;</span></h2>
                        <?php if(!empty($arrBidders)): ?>
                            <?php foreach ($arrBidders as $intKey=>$strValue): ?>
                                    <div class="search-user-box">
                                        <div class="search-user-img">
                                            <a href="tutors_profile.php?id=<?php echo $strValue['Id'];?>">
                                                <?php if(file_exists("upload/user/".$strValue['Photo']) && $strValue['Photo']!=''): ?>
                                                    <img alt="" src="<?php echo $objModule->SITEURL;?>timthumb.php?src=<?php echo $objModule->SITEURL;?>upload/user/<?php echo $strValue['Photo'];?>" />
                                                 <?php else:?>
                                                    <img alt="" src="<?php echo $objModule->SITEURL;?>timthumb.php?src=<?php echo $objModule->SITEURL;?>images/default.png" />
                                                <?php endif;?>
                                                
                                            </a>
                                        </div>
                                        <div class="search-user-cont">
                                        <div class="bidinfo"> <span>Bid Amout: $<span class="money"><?php echo $strValue['Bid_amt'];?></span></span>
                                            <div class="btnhire">
                                             <?php 
                                             if($arrPost[0]['win_status']==0 && $strValue['bid_status']==1):?>
                                                    <a class="accept" href="bidders_status.php?acpt_biddin_id=<?php echo $strValue['bid_id'];?>"><i class="fa fa-thumbs-o-up"></i></a>
                                                    <a class="decline" href="bidders_status.php?dcln_biddin_id=<?php echo $strValue['bid_id'];?>"><i class="fa fa-thumbs-o-down"></i></a>
                                                    <a class="accept" href="messages_detail.php?post_id=<?php echo $_GET['post_id'];?>&from=<?php echo $_SESSION['clg_userid']?>&to=<?php echo $strValue['bider_id'];?>"><i class="fa fa-wechat"></i></a>
                                             <?php elseif($arrPost[0]['win_status']==0 && $strValue['bid_status']==0):?>
                                                    <span class="blog_time">Status : <span style="color:red">Rejected</span></span>
                                             <?php else:?>   
                                                    <?php if($arrPost[0]['win_status']==1 && $strValue['bid_status']==3): ?>
                                                    <a class="decline" href="buyer-milestone.php?post_id=<?php echo $_GET['post_id'];?>">View milestone</a>
                                                    <a class="accept" href="messages_detail.php?post_id=<?php echo $_GET['post_id'];?>&from=<?php echo $_SESSION['clg_userid']?>&to=<?php echo $strValue['bider_id'];?>"><i class="fa fa-wechat"></i></a>  
                                                    <?php endif;?>
                                             <?php endif;?>   
                                            
                                            </div>
                                        </div>
                                        <!-- bidinfo -->
                                        <h2><a href="tutors_profile.php?id=<?php echo $strValue['Id'];?>"><?php echo $strValue['disp_name'];?></a></h2>
                                        <span><?php echo $strValue['cname'];?> <?php echo ($strValue['State']!='')?" ,".$strValue['State']:"";?></span>
                                        <br/>
                                        <span>Estimate Delivery Date <?php echo date("d M Y",  strtotime($strValue['delivery_date']));?></span>
                                        <p>
                                            <?php $intLength = strlen($strValue['Description']);
                                                if($intLength<=200):
                                                    echo $strValue['Description'];
                                                else:
                                                    echo substr($strValue['Description'], 0,200)."....";
                                                    echo '<br/><a class="sug_skil fancybox.ajax" data-attr="'.$strValue['bid_id'].'" href="ajax.php">View more</a>';
                                                endif;
                                            ?>
                                        </p> 
                                        </div>
                                    </div>
                            <?php endforeach;?>
                        <?php else:?>
                        <div class="search-user-box">
                            No bidders found
                        </div>
                        <?php endif;?>
                        <?php if($intTotal >$intNum): ?>
                        <div class="navigation">
                            <?php echo $objPagination->display().$objPagination->displaySelectInterface(); ?>
                        </div>
                        <?php endif;?>
                        <br class="clear" />
                        <br />
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
<div style="display: none;" id="inline_conent">
    <div class="popup-cont">
    </div>
</div>