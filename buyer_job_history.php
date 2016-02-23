<?php
include("lib/module.php");
//echo "<pre>";print_r($_SESSION);die;
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
if($_POST['btnAddReview']!='')
{
    $arrTo      =   $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_POST['hdnToUser']."' ");
    $arrPost    =   $objModule->getAll("SELECT * FROM tbl_post WHERE id = '".$_POST['hdnPostId']."' ");  
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_reviews","review_id");
    $objData->setFieldValues("review_from",$_SESSION['clg_userid']);
    $objData->setFieldValues("review_to",$_POST['hdnToUser']);
    $objData->setFieldValues("review_post",$_POST['hdnPostId']);
    $objData->setFieldValues("review_desc",$_POST['txtReview']);
    $objData->setFieldValues("review_date",date("Y-m-d H:i:s"));
    $objData->setFieldValues("review_rate",$_POST['rating']);
    $objData->insert();
    unset($objData);
    
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_notification","Id");
    $objData->setFieldValues("post_id",$_POST['hdnPostId']);
    $objData->setFieldValues("From_userId",$_SESSION['clg_userid']);
    $objData->setFieldValues("To_userId",$_POST['hdnToUser']);
    $objData->setFieldValues("Ntype",9);
    $objData->setFieldValues("Ndate",date("Y-m-d H:i:s"));
    $objData->setFieldValues("Status",'0');
    $objData->insert();
    unset($objData);
    
    $strTo =$arrTo[0]['Email'];
    
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
	</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:1px solid #e7e7e7;">
		<tr>
			<td>
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td valign="top" style="padding:20px;">
								<h2>Review added for the post !</h2>
								<br />
								<div class="textdark">
									Review added by '.$_SESSION['classgod_User'][0]['Username'].' for the post with the title '.$arrPost[0]['title'].'
                                                                </div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;color:#fff;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="center" valign="middle" class="textwhite" style="font-size:12px;padding:20px;">
								&copy; '.date("Y").' ClassGod.
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: ' . $objModule->INFO_MAIL;
            mail($strTo,"Review added for your job", $strMessage, $headers);
            $objModule->redirect("./buyer_job_history.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
                    <title>Class God</title>
                    <link rel="stylesheet" href="css/normalize.min.css">
                    <!--<link rel="stylesheet" href="css/main.css">-->
                    <link rel="stylesheet" href="css/examples.css">
                    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
                    <link href="css/style.css" rel="stylesheet" type="text/css" />
                    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
                    <script type="text/javascript" src="js/script.js"></script>
                    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
                    <script type="text/javascript" src="js/jquery.fancybox.js"></script>
                    <script type="text/javascript" src="js/expand.js"></script>
                    <script type="text/javascript" src="js/common.js"></script>
                    <script src="js/jquery.barrating.js"></script>
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
        <div class="header_img"><img src="images/about_inner.jpg" alt=""></div>
        <div class="header_textbox">
                              <div class="wrapper">
            <h1>My Assignment History</h1>
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
                          <?php include 'includes/buyer_sidebar.inc.php'; ?>
                          <!----Sidebar end---->
                          <div class="blog_part">
        <h2><span>Assignment History</span></h2>
        <?php
                                        $arrJobHistory = $objModule->getAll("select p.id,p.win_date,p.end_date,p.win_uid,p.title,b.Bid_amt,p.start_date_time,p.end_date_time from tbl_post p left join tbl_bidding b on p.id=b.Post_id where p.win_status='4' and p.uid=" . $_SESSION['classgod_User'][0]['Id'] . " GROUP BY p.`id` ORDER BY p.id desc ");
                                        //echo "<pre>";print_r($objModule);die;
                                        ?>
       
                              <ul class="work_rating">
            <?php
                                                if (count($arrJobHistory) > 0)
                                                {
                                                    foreach ($arrJobHistory as $history)
                                                    {
                                                        $arrCount = $objModule->getAll("SELECT COUNT(*) as tcnt FROM  tbl_reviews where review_post='" . $history['id'] . "' and review_from='" . $_SESSION['clg_userid'] . "'"); 
                                                        
                                                        $arrReviewData = $objModule->getAll("select review_desc,review_rate,case review_rate WHEN '1' THEN 'E' WHEN '2' THEN 'D' WHEN '3' THEN 'C' WHEN '4' THEN 'B' WHEN '5' THEN 'A' ELSE ''  end as revi from tbl_reviews where review_post='" . $history['id'] . "' and review_to='" . $_SESSION['clg_userid'] . "'");
                                                        ?>
            <li>
            <ul>
                <li>
                    <h4><?php echo $history['title']; ?></h4>
                    <?php echo date('M Y',strtotime($history['win_date'])); ?> - <?php echo date('M Y',strtotime($history['end_date'])); ?><br />
                    Fixed Price $<?php echo $history['Bid_amt']; ?><br />
                    <?php if($arrCount[0]['tcnt']==0):?>
                        <a data-post="<?php echo $history['id'];?>" data-to="<?php echo $history['win_uid'];?>" class="various1" href="#inline_content">Add Review</a>
                    <?php endif;?>    
                    </li>
                        <?php
                    if (count($arrReviewData) > 0)
                    {
                    ?>
                
                <li><?php echo $arrReviewData[0]['review_desc']; ?></li>
                <li><?php echo $arrReviewData[0]['revi'];?></li>
                <?php
                    }
                    else
                    {
                      ?>
                      
                                  <li><?php echo "No review given yet"; ?></li>
                                  <li><?php echo "No ratings given yet"; ?></li>
                                  <li></li>
                                  <?php
                                                        }
                                                        ?>
                                </ul>
            </li>
            <?php
                                                }
                                                ?>
          </ul>
                              <?php
                                            }
                                            else
                                            {
                                                echo "<h3>No Job completed Yet!!! <a href='addjob.php'>Click here</a> to post one</h3>";
                                            }
                                            ?>
                           
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
<div style="display: none;" id="inline_content">
  <div class="popup-cont">
    <h2>Enter your review</h2>
    <div class="regform">
      <form onsubmit="return frmvalidate(this.id);" name="frmAddskill" id="frmAddSkills" action="" method="POST">
        <div class="row">
          <div class="one_full">
            <textarea id="review_detail" placeholder="Write your review here" name="txtReview" class="required" maxlength="150"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="one_full">
              <select id="example-e" class="start_rate" name="rating">
              <option value="1">E</option>
              <option value="2">D</option>
              <option value="3">C</option>
              <option value="4">B</option>
              <option value="5">A</option>
            </select>
          </div>
        </div>
        <div class="row last">
          <div class="one_full">
              <input type="hidden" id="hdnPostId" name="hdnPostId" />
              <input type="hidden" id="hdnToUser" name="hdnToUser" />
            <input type="submit" name="btnAddReview" value="Add Review" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery(".various1").each(function(){
           var tthis = this;
            $(this).fancybox({
                maxWidth	: 300,
                maxHeight	: 300,
                fitToView	: false,
                width		: '70%',
                height		: '70%',
				autoResize : true,
				fitToView : true,
                autoSize	: true,
                closeClick	: false,
                openEffect	: 'none',
                closeEffect	: 'none',
                beforeLoad : function() {
                    
                    jQuery("#hdnPostId").val(jQuery(tthis).attr("data-post"));
                    jQuery("#hdnToUser").val(jQuery(tthis).attr("data-to"));
                    
                    jQuery(".start_rate").barrating('show', {
                        wrapperClass: 'br-wrapper-e',
                        initialRating: '1',
                        showValues: true,
                        showSelectedRating: false,
                        onSelect:function(value, text) {
                            
                        }
                    });
                }
            });
       }); 
    });
</script>