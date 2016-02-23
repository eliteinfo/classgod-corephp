<?php 
include('lib/module.php');
if ($_SESSION['clg_userid'] == '')
{
     $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
if ($_GET['acpt_biddin_id'] && $_GET['acpt_biddin_id'] != "")
{
    // for accept bid
    $sel_session_user = "SELECT * FROM tbl_users WHERE Id='" . $_SESSION['user_id'] . "'";
    $sel_bidder = "SELECT b.Id AS b_id, b.Post_id, b.Uid, b.Bid_amt, b.Description, b.create_at,u.Id AS u_id,u.*,p.*,c.* FROM tbl_bidding AS b
            LEFT JOIN  tbl_users AS u ON u.Id=b.Uid 
            LEFT JOIN tbl_post AS p ON p.id=b.Post_id 
            LEFT JOIN tbl_country AS c ON u.Country= c.Id
            WHERE b.Id='" . $_GET['acpt_biddin_id']. "' AND b.status='1'";
     $db_bidder = $objModule->getAll($sel_bidder);
     if(!empty($db_bidder))
     {
        $curr_date = date('Y-m-d H:i:s');
        $win_uid = $db_bidder[0]['Uid'];
        $win_postid = $db_bidder[0]['Post_id'];
        
        $update_post = "UPDATE tbl_post SET win_date='".$curr_date."', win_uid= '".$win_uid."', win_status='1' WHERE id='".$win_postid."' ";
        $db_update_post = $objModule->getAll($update_post);
        
        $update_bidd = "UPDATE tbl_bidding SET status='3' WHERE Post_id='".$win_postid."' AND  Uid = '".$win_uid."' ";
        $db_update_bidd = $objModule->getAll($update_bidd);
        
        $arrUsersBid = $objModule->getAll("SELECT tb.* FROM tbl_users tu  
                                            INNER JOIN tbl_bidding tb ON tu.Id = tb.Uid
                                            INNER JOIN tbl_post tp ON tp.id = tb.Post_id
                                            WHERE tp.id = '".$win_postid."' AND  tb.Uid !='".$win_uid."' AND tb.status = '1'    GROUP BY tu.Id ");
        
        if(!empty($arrUsersBid))
        {
            foreach($arrUsersBid as $intKey=>$strValue):
                $strUp  =   "UPDATE tbl_bidding set status ='2' WHERE  Uid = '".$strValue['Uid']."' AND Post_id = '".$win_postid."' AND  status = '1'  ";
                $arrUp  =   $objModule->getAll($strUp);    
            endforeach;
        }
        
        
        
        //NOTIFICATION FOR ACCEPT BID
        $ndate = date('Y-m-d H:i:s');
        $objData =  new  PCGData();
        $objData->setTableDetails("tbl_notification","Id");
        $objData->setFieldValues("post_id",$win_postid);
        $objData->setFieldValues("From_userId",$_SESSION['clg_userid']);
        $objData->setFieldValues("To_userId",$win_uid);
        $objData->setFieldValues("Ndate",$ndate);
        $objData->setFieldValues("Ntype",'4');
        $objData->setFieldValues("Status",'0');
        $objData->insert();
        $intLastId = $objData->intLastInsertedId;
        unset($objData);
        if($intLastId!='')
        {
            $to = $db_bidder[0]['Email'];
            $subject = "Notification for Accept Bid";
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
								<h2> Your Bid accepted!</h2>
								<br />
								<div class="textdark">
									<strong>Dear ' . ucfirst($db_bidder[0]['Username']) . ',</strong><br /><br />
									Congratulation!.., Your Bid for the job '.$db_bidder[0]['title'] . ' has been accepted by '.$db_user1[0]['Username'].'  Use the link below to see details. <a href="'.$objModule->SITEURL.'job_detail.php?post_id='.$db_bidder[0]['Post_id'].'&post_uid='. $_SESSION['clg_userid'] .'">Click here</a><br /><br />
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;color:#fff;">
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
            //$headers .= 'From:'. $db_session_user_acpt[0]['Email'] ;
            $headers .= 'From: ' . $objModule->INFO_MAIL;
            mail($to, $subject, $strMessage, $headers);
            echo "<script>window.location.href ='dashboard-buyer.php'</script>";
        }
     }
}
else if ($_GET['dcln_biddin_id'] && $_GET['dcln_biddin_id'] != "")
{
    $sel_session_user = "SELECT * FROM tbl_users WHERE Id='" . $_SESSION['user_id'] . "'";
    $db_session_user = $objModule->getAll($sel_session_user);
    $sel_bidder = "SELECT b.Id AS b_id, b.Post_id, b.Uid, b.Bid_amt, b.Description,u.Id AS u_id,u.*,p.*,c.* FROM tbl_bidding AS b
			   LEFT JOIN  tbl_users AS u ON u.Id=b.Uid 
			   LEFT JOIN tbl_post AS p ON p.id=b.Post_id 
			   LEFT JOIN tbl_country AS c ON u.Country= c.Id
			   WHERE b.Id='" . $_GET['dcln_biddin_id'] . "' AND b.status='1'";
    $db_bidder = $objModule->getAll($sel_bidder);
    
    $dcln_uid = $db_bidder[0]['Uid'];
    $dcln_postid = $db_bidder[0]['Post_id'];
    
    $update_bidd = "UPDATE tbl_bidding SET status='0' WHERE Post_id='".$dcln_postid."'  AND  id='" . $_GET['dcln_biddin_id'] . "'";
    $db_update_bidd = $objModule->getAll($update_bidd);
    
    $to = $db_bidder[0]['Email'];
    $subject = "Notification for Decline Bid";
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
								<h2> Your Bid rejected !</h2>
								<br />
								<div class="textdark">
									<strong>Dear ' . ucfirst($db_bidder[0]['Username']) . ',</strong><br /><br />
									Your Bid for the '.$db_bidder[0]['title'] . ' has been declined by '. ucfirst($db_session_user[0]['Name']) . ' Please continue to search for another job on our site.  <a href="' . $objModule->SITEURL.'search_jobs.php">Click here</a>
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;color:#fff;">
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
    $headers .= 'From: ' . $objModule->INFO_MAIL;
    mail($to, $subject, $strMessage, $headers);
    echo "<script>window.location.href = 'dashboard-buyer.php'</script>";
    
}
?>