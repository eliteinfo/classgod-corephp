<?php
include 'lib/module.php';
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}

if(isset($_GET['addcategory']) && $_GET['addcategory']!="")
{
	$getuser = $objModule->getAll("SELECT * FROM tbl_users WHERE Id='".$_SESSION['clg_userid']."'");
	$category=$getuser[0]['cat_id'].','.$_GET['addcategory'];
	$update = $objModule->getAll("UPDATE tbl_users SET cat_id='".$category."' WHERE Id='".$_SESSION['clg_userid']."'");
	$objModule->redirect("./job_detail.php?post_id=".$_GET['post_id']."&post_uid=".$_GET['post_uid']);
}
if (isset($_GET['post_id']) && $_GET['post_id'] == "")
{
    if (isset($_GET['post_uid']) && $_GET['post_uid'] == "")
    {
        $objModule->redirect("./search_jobs.php");
    }
}
if ($_POST['btnBidPost'] != '')
{
    if($_POST['bid_deliverydate']!='' && $_POST['bid_amount']!='')
    {
        $current_date = date('Y-m-d H:i:s');
        $strDelivery       = date("Y-m-d",  strtotime($_POST['bid_deliverydate']));
        $insert_bid = "INSERT INTO tbl_bidding(Id, Post_id, Uid, Bid_amt, Description,delivery_date,create_at,status) VALUES (NULL,'" . $_POST['hdn_postid'] . "','" . $_SESSION['clg_userid'] . "','" . $_POST['bid_amount'] . "','" . $_POST['txtBidDesc'] . "','".$strDelivery."','$current_date','1')";
        $db_bid = $objModule->getAll($insert_bid);
        
        
        // Notification inserted
        $insert_not_bidother = "INSERT INTO tbl_notification (Id, post_id, From_userId, To_userId, Ntype, Ndate, Status) VALUES (NULL,'".$_POST['hdn_postid']."','".$_SESSION['clg_userid']."','".$_POST['hdn_posterid']."',1,'".$current_date."',0)";
        $db_not_decl = $objModule->getAll($insert_not_bidother);
        
        // send mail to buyer
        $arrPostUSer = $objModule->getAll("SELECT * FROM tbl_users WHERE Id='".$_POST['hdn_posterid']."'");
        $arrBidUser  = $objModule->getAll("SELECT Username FROM tbl_users WHERE Id='".$_SESSION['clg_userid']."'");
        $to=$arrPostUSer[0]['Email'];
        $subject = "New Bid on Job ".$_REQUEST['hdn_posttitle']."";
        $strMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Metronic | Email 1</title>
	<style type="text/css">
		#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
		body{width:100% !important; margin:0; font-family:Open Sans;} 
		body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
		body{margin:0; padding:0;}
		img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
		table td{border-collapse:collapse;}
		#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700); /* Loading Open Sans Google font */ 
		body, #backgroundTable{ background-color:#FFF; }
		.TopbarLogo{
		padding:10px;
		text-align:left;
		vertical-align:middle;
		}
		h1, .h1{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:35px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h2, .h2{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:30px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h3, .h3{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:24px;
		font-weight:400;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h4, .h4{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:18px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h5, .h5{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:14px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		.textdark { 
		color: #444444;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.textwhite { 
		color: #fff;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.fontwhite { color:#fff; }
		.btn {
		background-color: #e5e5e5;
		background-image: none;
		filter: none;
		border: 0;
		box-shadow: none;
		padding: 7px 14px; 
		text-shadow: none;
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		font-size: 14px;  
		color: #333333;
		cursor: pointer;
		outline: none;
		-webkit-border-radius: 0 !important;
		-moz-border-radius: 0 !important;
		border-radius: 0 !important;
		}
		.btn:hover, 
		.btn:focus, 
		.btn:active,
		.btn.active,
		.btn[disabled],
		.btn.disabled {  
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		color: #333333;
		box-shadow: none;
		background-color: #d8d8d8;
		}
		.btn.red {
		color: white;
		text-shadow: none;
		background-color: #d84a38;
		}
		.btn.red:hover, 
		.btn.red:focus, 
		.btn.red:active, 
		.btn.red.active,
		.btn.red[disabled], 
		.btn.red.disabled {    
		background-color: #bb2413 !important;
		color: #fff !important;
		}
		.btn.green {
		color: white;
		text-shadow: none; 
		background-color: #35aa47;
		}
		.btn.green:hover, 
		.btn.green:focus, 
		.btn.green:active, 
		.btn.green.active,
		.btn.green.disabled, 
		.btn.green[disabled]{ 
		background-color: #1d943b !important;
		color: #fff !important;
		}
	</style>
</head><body>';
            $strMessage .='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343; height:52px;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="left" valign="middle" style="padding-left:20px; padding-top:5px;">
								<a href="' . $objModule->SITEURL . '">
								<img src="' . $objModule->SITEURL . 'images/logo2.png" width="246px" alt="Metronic logo"/>
								</a>
							</td>
							<td align="right" valign="middle" style="padding-right:0; padding-top:5px;">
								<table border="0" cellpadding="0" cellspacing="0" width="120px" style="height:100%;">
									<tr>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/fb_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/tw_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/youtube_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td style="padding:20px;">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px; height:100%;">
						<tr>
							<td valign="top" colspan="4">
								<h2>The New bid arrived on your post !</h2>
								<br />
								<div class="textdark">
									<strong>Dear '. ucfirst($arrPostUSer[0]['Username']) .',</strong><br/>
									'.ucfirst($arrBidUser[0]['Username']) .' has bidded on your job posted with title '.strtoupper($_REQUEST['hdn_posttitle']).'
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;">
								&copy; '.date("Y").' ClassGod.
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";	
        $headers .= 'From: '.$objModule->INFO_MAIL;
        if(mail($to,$subject,$strMessage,$headers))
        {
            $objModule->redirect("./thanksbid.php");
        }
    }
}
$arrPostDetail      =    $objModule->getAll("select p.id, p.category_id, p.title, p.uid, p.start_date_time, p.end_date_time, p.description, p.win_date, p.win_uid, p.price, p.win_status, p.created_date, p.zipcode,u.Photo, u.Status, u.User_type, u.Creation_date,c.name from tbl_post p,tbl_users u,tbl_category c WHERE u.id=p.uid AND p.id='" . $_GET['post_id'] . "' AND c.id=p.category_id");
$arrClientPost      =    $objModule->getAll("SELECT COUNT(*) AS tpcnt FROM tbl_post WHERE uid = '".$_GET['post_uid']."' ");
$arrUser            =    $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' ");   
$intRate = 0;
$arrRating = $objModule->getAll("SELECT AVG(review_rate) as avgrate FROM tbl_reviews WHERE review_to = '".$_GET['post_uid']."'  "); 
if($arrRating[0]['avgrate'] !='')$intRate = $arrRating[0]['avgrate'];

$arrPostAttach      =   $objModule->getAll("SELECT * FROM tbl_post_attach WHERE post_id = '".$_GET['post_id']."'"); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datetimepicker3').datetimepicker({
                        timepicker:false,
                        format:'d-m-Y',
                        minDate:'+1970/01/01',
                });
                  $('#datetimepicker3').scrollTop(0);
                $(".linkwatchlist").click(function () {
                    alert('Job post has been added to your watchlist.');
                    $(this).hide();
                    $('.remwatchlist').show();
                    return false;
                });
                $(".option_button1").click(function () {
                    $("#bidform").slideDown(500);
                    $(this).hide();
                    return false;
                });
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
                        <div class="header_img"><img src="images/about_inner.jpg" alt=""></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Job Details</h1>
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
                        <div class="category_box">
                            <div class="sidebar_box">
                                <div class="bid_box">
                                    <?php 
                                    if($arrPostDetail[0]['win_status']==0)
                                    {?>
                                    
                                    <?php if ($_SESSION['clg_usertype'] == 1):
									    $cat_array=explode(',',$arrUser[0]['cat_id']);
                                        if(in_array($arrPostDetail[0]['category_id'],$cat_array))
                                        {
                                                $arrExistBid   =    $objModule->getAll("SELECT COUNT(*) AS tcnt FROM tbl_bidding WHERE Uid = '".$_SESSION['clg_userid']."' AND Post_id = '".$_GET['post_id']."' ");
                                                if($arrExistBid[0]['tcnt']==0):   
                                        ?> 
                                        <div id="bidform" class="regform">
                                            <form action="" id="frmBid" method="post" onsubmit="return frmvalidate(this.id);">
                                                <div class="row">
                                                    <div class="one_full"><label>Enter Description:</label>
                                                        <textarea class="required" name="txtBidDesc"></textarea></div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Bid Amount:</label>
                                                        <input class="onlynumber required" name="bid_amount" kl_virtual_keyboard_secure_input="on" type="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Estimate Delivery Date:</label>
                                                        <input class="required" id="datetimepicker3" name="bid_deliverydate"  type="text" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row sbmt">
                                                    <div class="one_full">
                                <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                           <input type="hidden" id="hdn_catid" name="hdn_catid" value="<?php echo $db_postdet[0]['category_id']; ?>" />
                           <input type="hidden" id="hdn_posttitle" name="hdn_posttitle" value="<?php echo $arrPostDetail[0]['title']; ?>" />
                                                        <input value="Submit Bid" name="btnBidPost" type="submit">
                                                    </div>
                                                </div>    
                                            </form>
                                        </div>
                                        <a href="#" class="option_button1">Bid on Job</a><h6>**Be aware that a 10% service fee will be deducted from total payment before funds are released to tutor.</h6>
                                    <?php else:?>
                                        <a href="detail-bidded.php?post_id=<?php echo $_GET['post_id'];?>&job=act&post_uid=<?php echo $_GET['post_uid'];?>" class="option_button2">You already bidded <br/>view bid details </a>
                                    <?php endif;?>
                                        <?php }
                                        else
                                        {
                              echo '<div class="nodata" style="color:#F00;">Please Subcribe for '.$arrPostDetail[0]['name']. ' category</br> <a href="'.$fullurl.'&addcategory='.$arrPostDetail[0]['category_id'].'"><b>click here to subscribe</b></a></div>';
                                        }
?>
                                    <?php else:?>
                                        <a href="viewbidders.php?post_id=<?php echo $_GET['post_id'];?>" class="option_button2">View Bidders</a>
                                    <?php endif;?>  
                                    <?php 
                                    }
                                    else if($arrPostDetail[0]['win_status']==1)
                                    {?>
                                        <span class="option_button3">Awarded</span><br /><br /><br />
                                        <a href="buyer-milestone.php?post_id=<?php echo $_REQUEST['post_id']; ?>&post_uid=<?php echo $_REQUEST['post_uid']; ?>">View Milestone</a> |
                                        <a href="messages_detail.php?post_id=<?php echo $_REQUEST['post_id']; ?>&from=<?php echo $_REQUEST['post_uid'];?>&to=<?php echo $arrPostDetail[0]['win_uid'];?>">Messages</a>
                                        
                                    <?php }
                                    else if($arrPostDetail[0]['win_status']==3)
                                    {
                                        ?>
                                        <a href="javascript://" class="option_button2">Not Awarded</a><br><br>
                                    <?php }
                                    else if($arrPostDetail[0]['win_status']==4)
                                    {
                                        ?>
                                        <a href="javascript://" class="option_button2">Completed</a><br><br>
                                    <?php }
                                    ?>    
                                    
                                </div>
                            </div>
                            <div class="sidebar_box">
                            	<ul class="icon-list2">                                	
                                    <li><div class="icn"><span><i class="fa fa-star"></i></span></div><div class="tit"><strong><?php echo number_format((float)$intRate, 1, '.', '');?></strong><img src="images/gold_star/star_<?php echo $objModule->roundDownToHalf($intRate); ?>.png"</div></li>                                    
                                    <li><div class="icn"><span><i class="fa fa-edit"></i></span></div><div class="tit"><strong><?php echo date("d,  M Y",  strtotime($arrPostDetail[0]['created_date']));?></strong><br />Posted on</div></li>
                                    <li><div class="icn"><span><i><img alt="" src="images/icon18.png" /></i></span></div><div class="tit"><strong><?php echo $arrClientPost[0]['tpcnt'];?></strong>Job Posted</div></li>
                                    <li><div class="icn"><span><i class="fa fa-tint"></i></span></div><div class="tit"><strong><?php
                                                $strCur  = strtotime(date("Y-m-d H:i:s"));
                                                $strEnd  = strtotime($arrPostDetail[0]['end_date_time']);
                                                if($strEnd>$strCur)
                                                {
                                                    $diff    = $strEnd-$strCur;
                                                    $intDays = round($diff / 86400);
                                                    if($intDays>0)
                                                    {
                                                        echo $intDays."</strong>Days Left";
                                                    }
                                                    else if($intDays==0)
                                                    {
                                                        echo '1'."</strong>Days Left";
                                                    }
                                                    else
                                                    {
                                                        echo '0'."</strong>Days Left";
                                                    }
                                                }
                                                else
                                                {
                                                    if($arrPostDetail[0]['win_status']==3)
                                                    {
                                                        echo "Not awarded</strong>";
                                                    }
                                                    else if($arrPostDetail[0]['win_status']==1)
                                                    {
                                                         echo "Running</strong>";
                                                    }
                                                }
                                                
                                                ?></div></li>
                                    <li><div class="icn"><span><i class="fa fa-edit"></i></span></div><div class="tit"><strong><?php echo date("d,  M Y",  strtotime($arrPostDetail[0]['end_date_time']));?></strong><br />Due date</div></li>
                                </ul>
                            	
                                
                            </div>
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><?php echo $arrPostDetail[0]['title']; ?></h2>
                        <div class="post_date"><div class="pm"><strong>Posted on:</strong> <?php echo date("d,  M Y",  strtotime($arrPostDetail[0]['created_date']));?></div><div class="pm"><strong>Category:</strong> <?php echo $arrPostDetail[0]['name'];?></div>
                            <div class="blog_price">
                                <ul>
<!--                                    <li><span class="red">Fixed Price</span></li>-->
                                    <li>Est. Budget
                                    <?php if($arrPostDetail[0]['price']!='' && $arrPostDetail[0]['price']!=0):?>
                                    $<span class="money"><?php echo $arrPostDetail[0]['price']; ?></span></li>
                                    <?php else:?>
                                    <li><span class="money">N/A</span></li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                        <div class="pro_detail">
                            <?php echo $arrPostDetail[0]['description']; ?>
                        </div>
                        <?php if(!empty($arrPostAttach)): ?>
                        <ul class="attach-list">

                                <?php
                                $l=0;
                                foreach($arrPostAttach as $intK=>$strV): ?>
                                    <?php if(file_exists("upload/attachment/".$strV['post_id']."/".$strV['filename']) && $strV['filename']!=''):
                                        if($l==0)
                                        { ?>
                                            <h3>Attachments:</h3><br>
                                            <?php
                                        }
                                                $strEx = strtolower(pathinfo("upload/attachment/".$strV['post_id']."/".$strV['filename'],PATHINFO_EXTENSION));?>
                                                    <li><a download target="_blank" href="<?php echo $objModule->SITEURL;?>upload/attachment/<?php echo $strV['post_id'];?>/<?php echo $strV['filename'];?>" class="jp-sprite <?php echo $objModule->getClass($strEx);?>"><p style="font-size:15px;margin-top:0px;"><span><?php echo $strV['filename'];?></span></p></a></li>
                                   <?php endif;?>
                                <?php
                                $l++;
                                endforeach;?>
                        </ul>                                            
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