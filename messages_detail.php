<?php

include 'lib/module.php';

if ($_SESSION['clg_userid'] == '')

{

    $objModule->redirect("./login.php");

}

if($_SESSION['clg_usertype']==1)

{

    $updateMsg = $objModule->getAll("UPDATE tbl_messages SET is_read = '1' WHERE To_user = '".$_SESSION['clg_userid']."' AND Post_id = '".$_GET['post_id']."'  AND is_read = '0'");

}

else

{

    $updateMsg = $objModule->getAll("UPDATE tbl_messages SET is_read = '1' WHERE To_user = '".$_SESSION['clg_userid']."' AND From_user = '".$_GET['to']."' AND Post_id = '".$_GET['post_id']."'  AND is_read = '0'");

}

$arrPostDetail = $objModule->getAll("SELECT * FROM tbl_post WHERE id = '" . $_GET['post_id'] . "' ");

$arrCurUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '" . $_SESSION['clg_userid'] . "' ");

$arrOthr = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '" . $_GET['to'] . "' ");



if (!empty($arrCurUser))

{

    $strPhoto = $objModule->SITEURL . "images/default.png";

    if (file_exists("upload/user/" . $arrCurUser[0]['Photo']) && $arrCurUser[0]['Photo'] != '')

    {

        $strPhoto = $objModule->SITEURL . "upload/user/" . $arrCurUser[0]['Photo'];

    }

    $strName = ucfirst($arrCurUser[0]['Username']);

}

if (!empty($arrOthr))

{

    $strOthPhoto = $objModule->SITEURL . "images/default.png";

    if (file_exists("upload/user/" . $arrOthr[0]['Photo']) && $arrOthr[0]['Photo'] != '')

    {

        $strOthPhoto = $objModule->SITEURL . "upload/user/" . $arrOthr[0]['Photo'];

    }

    $strOthName = ucfirst($arrOthr[0]['Username']);

}

$user_message = "SELECT m.* from tbl_messages m where Post_id = '" . $_GET['post_id'] . "' AND ((m.From_user='" . $_SESSION['clg_userid'] . "' and m.To_user='" . $_GET['to'] . "') or (m.From_user='" . $_GET['to'] . "' and m.To_user='" . $_SESSION['clg_userid'] . "'))  order by m.Id asc";

$db_message = $objModule->getAll($user_message);



//send Messages code

if ($_POST['btnSubmit'] != '')

{

    $current_date = date("Y-m-d H:i:s");

    $sel_conv = "SELECT Id FROM tbl_messages WHERE (From_user = '" . $_SESSION['clg_userid'] . "' AND  To_user = '" . $_GET['to'] . "') or (From_user = '" . $_GET['to'] . "' AND  To_user ='" . $_SESSION['clg_userid'] . "')";

    $conv_db = $objModule->getAll($sel_conv);

    $redirect_var = "from=" . $_SESSION['clg_userid'] . "&to=" . $_GET['to'] . "&post_id=" . $_GET['post_id'];

    if (count($conv_db) > 0)

    {

        $conversation = 0;

    }

    else

    {

        $conversation = 1;

    }

    $insert_msg = "INSERT INTO tbl_messages (From_user, To_user,Post_id,Message, Create_date,Conversion,Date) VALUES ('" . $_SESSION['clg_userid'] . "','" . $_GET['to'] . "','" . $_GET['post_id'] . "','" . $_POST['txtMessage'] . "','" . $current_date . "','" . $conversation . "','" . $current_date . "')";

    $intNewId = $objModule->getAll($insert_msg);



    $insert_not_msg = "INSERT INTO tbl_notification (Id, From_userId, To_userId,post_id, Ntype, Ndate, Status) VALUES (NULL,'" . $_SESSION['clg_userid'] . "','" . $_GET['to'] . "','" . $_GET['post_id'] . "',2,'" . $current_date . "',0)";

    $db_not_msg = $objModule->getAll($insert_not_msg);



    $sel_to_user1 = "SELECT * FROM tbl_users WHERE Id='" . $_GET['to'] . "'";

    $db_to_user1 = $objModule->getAll($sel_to_user1);

    $to = $db_to_user1[0]['Email'];

    $subject = "Notification for Receive Message ";

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

								<h2>You got new message !</h2>

								<br />

								<div class="textdark">

									<strong>Dear ' . $db_to_user1[0]['fname'] . ' ' . $db_to_user1[0]['lname'] . ',</strong><br /><br />

									There is One Unread Message In your Inbox..<br /><br />

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

								&copy; ' . date("Y") . ' ClassGod.

							</td>

						</tr>

					</table>

				</center>

			</td>

		</tr>

	</table>';

    $headers = "MIME-Version: 1.0" . "\r\n";

    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    $headers .= 'From: ' . $objModule->INFO_MAIL;

    mail($to, $subject, $strMessage, $headers);

    echo "<script>window.location.href = 'messages_detail.php?" . $redirect_var . "'</script>";

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

                        <h1>Messages</h1>

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

            <?php if($_SESSION['clg_usertype']==1):

                include 'includes/turor_lefbar.inc.php';

            else:

                include 'includes/buyer_sidebar.inc.php';

            endif;

            ?>

            <!----Sidebar end---->

            <div class="blog_part">

                <div class="message_header">

                    <img width="48" height="48" src="<?php echo $strPhoto; ?>" class="avatar photo" alt="">

                    <h2><?php echo $arrPostDetail[0]['title']; ?></h2>

                    <?php if (!empty($db_message)): ?>

                        <p><span class="label">From:</span>

                            <?php

                            if($db_message[0]['From_user']==$_SESSION['clg_userid']):

                                echo $strName;

                            else:

                                echo $strOthName;

                            endif;

                            ?>



                        </p>

                        <p><span class="label">Date:</span><?php echo date("D, d M",  strtotime($db_message[0]['Create_date']));?> at <?php echo date("h:ia",strtotime($db_message[0]['Create_date']));?> </p>

                    <?php endif; ?>



                </div>



                <?php if (!empty($db_message)): ?>

                    <ul class="notifi-list">

                        <?php foreach ($db_message as $strValue): ?>

                            <li>

                                <?php if ($strValue['From_user'] == $_SESSION['clg_userid']): ?>

                                    <div class="msg-title">

                                        <img src="<?php echo $objModule->SITEURL;?>timthumb.php?src=<?php echo $strPhoto; ?>&w=48&h=48&a=t" alt="" class="avatar photo" />
                                        <!--<img width="48" height="48" src="<?php /*echo $strPhoto;*/?>" class="avatar photo" alt="">-->

                                    </div>

                                    <div class="msgpost-text">

                                        <h2><?php echo $strName;?><span class="dt"><?php echo date("D, d M",  strtotime($strValue['Create_date']));?> at <?php echo date("h:ia",strtotime($strValue['Create_date']));?></span></h2>

                                        <p><?php echo $strValue['Message'];?></p>





                                    </div>

                                <?php else:?>

                                    <div class="msg-title">
                                        <img src="<?php echo $objModule->SITEURL;?>timthumb.php?src=<?php echo $strOthPhoto; ?>&w=48&h=48&a=t" alt="" class="avatar photo" />

                                        <!--<img width="48" height="48" src="<?php /*echo $strOthPhoto;*/?>" class="avatar photo" alt="">                            -->

                                    </div>

                                    <div class="msgpost-text">

                                        <h2><?php echo $strOthName;?><span class="dt"><?php echo date("D, d M",  strtotime($strValue['Create_date']));?> at <?php echo date("h:ia",strtotime($strValue['Create_date']));?></span></h2>

                                        <p><?php echo $strValue['Message'];?></p>



                                    </div>

                                <?php endif; ?>



                            </li>

                        <?php endforeach; ?>

                    </ul>

                <?php else: ?>

                    <ul class="notifi-list"><li>No Messages.</li></ul>

                <?php endif; ?>

                <?php if($arrPostDetail[0]['win_status']!=3 && $arrPostDetail[0]['win_status']!=4):?>

                    <div class="regform" style="max-width:100%;">

                        <form method="POST" name="frmMessages" id="frmMessages" onsubmit="return frmvalidate(this.id)">

                            <div class="row"><div class="one_full"><textarea <?php if($arrPostDetail[0]['win_status']==3 || $arrPostDetail[0]['win_status']==4): echo 'disabled'; endif;?> placeholder="Comment" class="required" name="txtMessage"></textarea></div></div>

                            <div class="row"><div class="one_full" align="right"><input type="submit" name="btnSubmit" <?php if($arrPostDetail[0]['win_status']==3 || $arrPostDetail[0]['win_status']==4): echo 'disabled'; endif;?> value="Submit" /></div></div>

                        </form>

                    </div>

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