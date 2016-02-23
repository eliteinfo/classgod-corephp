<?php 
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    echo '<script>window.top.location.href="login.php"</script>';
}
if ($_SESSION['clg_usertype'] == 0)
{
    //redirect to buyer dashboard if access
    echo '<script>window.top.location.href="dashboard-buyer.php"</script>';
}
if (isset($_GET['mId']) && $_GET['mId'] == "")
{
    echo '<script>window.top.location.href="tutordashboard.php"</script>';
}
$intMileId  =    base64_decode($_REQUEST['mId']);
$arrDetail  =    $objModule->getAll("SELECT tm.*,tp.id as post_id,tp.uid as puid,tp.`title` AS post_title,tu.`Email`,tu.Username FROM `tbl_milestone` tm
	INNER JOIN `tbl_post` tp ON tp.`id` = tm.`post_id`
        INNER JOIN `tbl_users` tu ON tu.`Id` = tp.`win_uid`
        WHERE tm.`id` = '".$intMileId."' ");  
if($_POST['btnPaymentReq']!='')
{
    if($_POST['txtDescription']!='')
    {
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
								<h2>Payment Request for milestone !</h2>
								<br />
								<div class="textdark">
									<strong>Dear Admin,</strong><br/>
									' . ucfirst($arrDetail[0]['Username']) . ' has request for payment of his milestone on  job ' . strtoupper($arrDetail[0]['post_title']) . '
                                                                            <br/>Milestone details is as below
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:1px solid #e7e7e7; color:#444444;">
		<tr>
			<td style="padding:20px;">
				<center>
					<table border="0" cellpadding="5px" cellspacing="0" width="100%" style="height:100%; border-left:1px solid #ccc; border-top:1px solid #ccc;">
                    <thead style="background-color:#efefef;">
			<tr>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Tutor</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Post Title</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Milestone</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Cost</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Note</th>
                        </tr>
                    </thead>
                    <tbody><tr>
                                    <td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . ($arrDetail[0]['Username']) . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . $arrDetail[0]['post_title'] . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . $arrDetail[0]['title'] . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' .$arrDetail[0]['cost'] . '</td>
                                        <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' .$_POST['txtDescription'] . '</td>
                                </tr></tbody>                            
			</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;color:#fff">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="center" valign="middle" class="textwhite" style="font-size:12px;padding:20px;">
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
        $headers .= 'From: ' . $arrDetail[0]['Email'];
        mail($objModule->INFO_MAIL, "Milestone payment request !", $strMessage, $headers);
        
        $objModule->getAll("UPDATE tbl_milestone SET is_req = '1' WHERE id = '".$arrDetail[0]['id']."' ");
        
        
        $objModule->setMessage("Payment Request sent successfully","success");
        echo '<script>window.top.location.href="detail-bidded.php?post_id='.$arrDetail[0]['post_id'].'&job=act&post_uid='.$arrDetail[0]['puid'].'"</script>';
    }
    else
    {
        $objModule->setMessage("Enter description","error");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
    </head>
    <body>
        
    <div class="popup-cont">
        <h2>Send Payment Request</h2>
        <div class="regform">
        <form onsubmit="return frmvalidate(this.id);" name="frmRequest" id="frmRequest" action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="one_full">
                    <label>Post Title </label>
                    <input type="text" disabled value="<?php echo $arrDetail[0]['post_title'];?>" />
                </div>
            </div>
            
            <div class="row">
                <div class="one_full">
                    <label>Milestone </label>
                    <input type="text" disabled value="<?php echo $arrDetail[0]['title'];?>" />
                </div>
            </div>
            
            <div class="row">
                <div class="one_full">
                    <label>Milestone </label>
                    <input type="text" disabled value="$  <?php echo $arrDetail[0]['cost'];?>" />
                </div>
            </div>
            
            <div class="row">
                <div class="one_full">
                    <textarea name="txtDescription" placeholder="Enter Description" class="required"></textarea>
                </div>
            </div>
            <br/>
            <div class="row last">
                <div class="one_full">
                    <input type="submit" name="btnPaymentReq" value="Send Payment Request" />
                </div>
            </div>
        </form>
        </div>
    </div>

    </body>
</html>