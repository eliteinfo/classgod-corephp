<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if($_SESSION['clg_usertype']==1)
{
    //redirect to tutor dashboard if access
    $objModule->redirect("./tutordashboard.php");
}
if (isset($_GET['post_id']) && $_GET['post_id'] == "")
{
    if (isset($_GET['post_uid']) && $_GET['post_uid'] == "")
    {
        $objModule->redirect("./dashboard-buyer.php");
    }
}

if (isset($_GET['job_id']) && $_GET['job_id']!= "")
{
        $mid=$objModule->getAll("select * from tbl_temp_payment where post_id='".$_GET['job_id']."' and post_close='1'");
		if(count($mid)>0){
			$payment=$objModule->getAll("select * from tbl_milestone_payment where post_id='".$_GET['job_id']."' and mid='".$mid[0]['mid']."' and transaction_id!=''");
			if(count($payment)>0){
				$arrPostupdate  =   $objModule->getAll("UPDATE tbl_post SET win_status = '4',end_date = '".date("Y-m-d H:i:s")."' WHERE id  = '".$_GET['job_id']."' ");
			}
			$arrDelete = $objModule->getAll("DELETE FROM tbl_temp_payment WHERE id = '".$mid[0]['id']."' ");
		}
        $objModule->redirect("./buyer-milestone.php?post_id=".$_GET['post_id']."&post_uid=".$_GET['post_uid']);
}
$arrPostDetail      =    $objModule->getAll("select p.id, p.category_id, p.title, p.uid, p.start_date_time, p.end_date_time, p.description, p.win_date, p.win_uid, p.price, p.win_status, p.created_date, p.zipcode,u.Photo, u.Status, u.User_type, u.Creation_date,c.name from tbl_post p,tbl_users u,tbl_category c WHERE u.id=p.uid AND p.id='" . $_GET['post_id'] . "' AND c.id=p.category_id");
$arrClientPost      =    $objModule->getAll("SELECT COUNT(*) AS tpcnt FROM tbl_post WHERE uid = '".$_SESSION['clg_userid']."' ");
$arrUser            =    $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."' ");   
if($arrPostDetail[0]['uid']!=$_SESSION['clg_userid'])
{
    $objModule->redirect("./dashboard-buyer.php");
}
$arrMileStone   =   $objModule->getAll("SELECT *,CASE status when '0' then 'Not accepted' when '1' then 'Accepted' when '2' then 'Rejected' else 'Done' end as m_status FROM tbl_milestone WHERE post_id = '".$_GET['post_id']."' ");
if($_POST['btnAccoept']!='' && $_POST['hdnMId']!='')
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_milestone","id");
    $objData->setFieldValues("status",'1');
    $objData->setWhere("id = '".$_POST['hdnMId']."' AND post_id = '".$_GET['post_id']."'  ");
    $objData->update();
    unset($objData);
    
    // send Notification to tutor for accept milestone
    
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_notification","Id");
    $objData->setFieldValues("post_id",$_POST['hdnMId']);
    $objData->setFieldValues("From_userId",$_SESSION['clg_userid']);
    $objData->setFieldValues("To_userId",$arrPostDetail[0]['win_uid']);
    $objData->setFieldValues("Ntype",'6');
    $objData->setFieldValues("Ndate",date("Y-m-d H:i:s"));
    $objData->setFieldValues("Status",0);
    $objData->insert();
    $intNId = $objData->intLastInsertedId;
    unset($objData);
    
    if($intNId!='')
    {
        $arrWinUser     =   $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$arrPostDetail[0]['win_uid']."' ");
        $arrMLDetail    =   $objModule->getAll("SELECT * FROM tbl_milestone WHERE id = '".$_POST['hdnMId']."' ");
        
        $strTo          =   $arrWinUser[0]['Email'];
        $strSubject     =   "Your milestone is accepted  for the".$_REQUEST['hdn_posttitle'];
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
								<h2>Your milestone is accepted !</h2>
								<br />
								<div class="textdark">
									<strong>Dear '. ucfirst($arrWinUser[0]['disp_name']) .',</strong><br /><br />
									'.$arrUser[0]['Username'].' has accept your milestone for the post <br/>'.$_REQUEST['hdn_posttitle'].'<br/></br/>
                                                                        Milestone Detail    
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
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">No</th>
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Title</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Cost</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Estimate Delivery Date</th>
                            
						</tr>
                    </thead>
                    <tbody>    
                        <tr>
                        	<td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">1</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrMLDetail[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">$ '.$arrMLDetail[0]['cost'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.date("d M Y",  strtotime($arrMLDetail[0]['edate'])).'</td>
                        </tr>
                        </tbody>                            
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
        $headers .= 'From: '.$objModule->INFO_MAIL;
        mail($strTo,$strSubject,$strMessage,$headers);
        
    }
    $objModule->redirect("./buyer-milestone.php?post_id=".$_GET['post_id']."&post_uid=".$_GET['post_uid']);
}
if($_POST['btnReject']!='' && $_POST['hdnMId']!='')
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_milestone","id");
    $objData->setFieldValues("status",'2');
    $objData->setWhere("id = '".$_POST['hdnMId']."' AND post_id = '".$_GET['post_id']."'  ");
    $objData->update();
    unset($objData);
    
     // send Notification to tutor for Reject milestone
    
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_notification","Id");
    $objData->setFieldValues("post_id",$_POST['hdnMId']);
    $objData->setFieldValues("From_userId",$_SESSION['clg_userid']);
    $objData->setFieldValues("To_userId",$arrPostDetail[0]['win_uid']);
    $objData->setFieldValues("Ntype",'7');
    $objData->setFieldValues("Ndate",date("Y-m-d H:i:s"));
    $objData->setFieldValues("Status",0);
    $objData->insert();
    $intNId = $objData->intLastInsertedId;
    unset($objData);
    
    if($intNId!='')
    {
        $arrWinUser     =   $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$arrPostDetail[0]['win_uid']."' ");
        $arrMLDetail    =   $objModule->getAll("SELECT * FROM tbl_milestone WHERE id = '".$_POST['hdnMId']."' ");
        
        $strTo          =   $arrWinUser[0]['Email'];
        $strSubject     =   "Your milestone is rejected  for the".$_REQUEST['hdn_posttitle'];
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
								<h2>Your milestone is rejected !</h2>
								<br />
								<div class="textdark">
									<strong>Dear '. ucfirst($arrWinUser[0]['disp_name']) .',</strong><br /><br />
									'.$arrUser[0]['Username'].' has reject your milestone for the post <br/>'.$_REQUEST['hdn_posttitle'].'<br/>
                                                                        Milestone Detail    
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
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">No</th>
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Title</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Cost</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Estimate Delivery Date</th>
                            
						</tr>
                    </thead>
                    <tbody>    
                        <tr>
                        	<td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">1</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrMLDetail[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">$ '.$arrMLDetail[0]['cost'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.date("d M Y",  strtotime($arrMLDetail[0]['edate'])).'</td>
                        </tr>
                        </tbody>                            
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
        $headers .= 'From: '.$objModule->INFO_MAIL;
        mail($strTo,$strSubject,$strMessage,$headers);
    }
    $objModule->redirect("./buyer-milestone.php?post_id=".$_GET['post_id']."&post_uid=".$_GET['post_uid']);
}

$intRate = 0;
$arrRating = $objModule->getAll("SELECT AVG(review_rate) as avgrate FROM tbl_reviews WHERE review_to = '".$_SESSION['clg_userid']."'  "); 
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
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.js"></script>
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
                jQuery(".iframe").fancybox({
                        width : 300,
                        height: 400, 
                        autoSize : false,
                        scrolling : 'no',
                        fitToView : true,
                        type    :'iframe'
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
                                    <span class="option_button3">Awarded</span><br /><br /><br />
                                    <a href="messages_detail.php?post_id=<?php echo $_REQUEST['post_id']; ?>&from=<?php echo $_REQUEST['post_uid'];?>&to=<?php echo $arrPostDetail[0]['win_uid'];?>">Messages</a>                                   
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
                                                }
                                                if($intDays>0)
                                                {
                                                    echo $intDays;
                                                }
                                                else if($intDays==0)
                                                {
                                                    echo 1;
                                                }
                                                else
                                                {
                                                    echo 0;
                                                }
                                                ?></strong>Days Left</div></li>
                                </ul>
                            	
                                
                            </div>
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><?php echo $arrPostDetail[0]['title']; ?></h2>
						
                        <div class="post_date">
  <div class="pm"><strong>Posted on:</strong> <?php echo date("d,  M Y",  strtotime($arrPostDetail[0]['created_date']));?></div>
  <div class="pm"><strong>Category:</strong> <?php echo $arrPostDetail[0]['name'];?></div>
  <div class="blog_price">
    <ul>
<!--                                    <li><span class="red">Fixed Price</span></li>-->
                                    <li>Est. Budget
                                    <?php if($arrPostDetail[0]['price']!='' && $arrPostDetail[0]['price']!=0):?>
                                    $<span class="money"><?php echo $arrPostDetail[0]['price'];?></span></li>
                                    <?php else:?>
                                    <li><span class="money">N/A</span></li>
                                    <?php endif;?>
                                </ul>
  </div>
</div>
                        <div class="pro_detail">
                            <?php echo $arrPostDetail[0]['description']; ?>
                        </div><div class="clear"></div>

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
					
					<div class="blog_part">
					<?php 
					/*if($_REQUEST['flag']=='0'){ ?>
					 <h3> Payment not done. </h3>
					<?php 
					} else { */
						$mid=$objModule->getAll("select * from tbl_temp_payment where post_id='".$_GET['post_id']."' and post_close='1'");
						if(count($mid)>0){
							$payment=$objModule->getAll("select * from tbl_milestone_payment where post_id='".$_GET['post_id']."' and mid='".$mid[0]['mid']."' and transaction_id!=''");
							//$payment=$objModule->getAll("select * from tbl_milestone_payment where post_id='".$_GET['post_id']."' and transaction_id!=''");
							if(count($payment)>0){
								$arrPostget  =   $objModule->getAll("select * from tbl_post where win_status = '4' and id  = '".$_GET['post_id']."' ");
							}
						}
						if(count($arrPostget)>0){
					     ?>
                         <h3> This job has been marked as done. </h3>
						
					     <?php } else if(count($payment)>0){ ?>
					     <h3> <input type="checkbox" id="checking" onclick="return job_done('<?php echo $_REQUEST['post_id']; ?>');" name="btnClosepost" value="1" />&nbsp;Mark this job as done ?</h3>
			            <?php }
				//	} ?>
					</div>
					<div>&nbsp;</div>

                    <div class="blog_part">
                        <h3>Milestone:</h3>
                        <div class="table_info">
                        <table cellpadding="0" cellspacing="0" border="0" class="tbl_style1">
                            <tr>
                                <th>No.</th>
                                <th align="left" width="20%">Title</th>
                                <th align="left">Cost</th>
                                <th align="left">Est. Delivery Date</th>
                                <th align="left">Status</th>
                                <th align="left">Action</th>
                            </tr>
                            <?php if(!empty($arrMileStone)): ?>
                                <?php foreach($arrMileStone as $intKey=>$strValue): ?>
                                    <tr>
                                        <td align="center"><?php echo ($intKey+1);?></td>
                                        <td><?php echo $strValue['title'];?></td>
                                        <td>$<?php echo $strValue['cost'];?></td>
                                        <td><?php echo date("d M Y",  strtotime($strValue['edate']));?></td>
                                        <td><?php echo $strValue['m_status'];?></td>
                                        <td>
                                            <form method="post" action="">
                                                <input type="hidden" name="hdnMId" value="<?php echo $strValue['id'];?>" />
                                                <input type="hidden" id="hdn_posttitle" name="hdn_posttitle" value="<?php echo $arrPostDetail[0]['title']; ?>" />
                                                <?php if($strValue['status']==0): ?>
                                                    <button class="icnbtn" type="submit" value="Accept" name="btnAccoept"><i class="fa fa-thumbs-up"></i></button>
                                                    <button class="icnbtn" type="submit" value="Reject" name="btnReject"><i class="fa fa-thumbs-down"></i></button>
                                                <?php elseif($strValue['status']==1):?>
                                                    <?php
                                                        $arrDo  =   array();
                                                        $arrDo  =   $objModule->getAll("SELECT * From tbl_assignment WHERE mid = '".$strValue['id']."' AND cstatus = '1' ORDER BY id DESC LIMIT 1  ");
                                                    ?>
                                                    <?php if(count($arrDo>0) && file_exists("upload/assignment/".$arrDo[0]['filename']) && $arrDo[0]['filename']!=''): ?><a download target="_blank" href="<?php echo $objModule->SITEURL;?>upload/assignment/<?php echo $arrDo[0]['filename'];?>">Download</a> | <?php endif;?>
                                                    <a class="iframe"  href="mpayment.php?post_id=<?php echo base64_encode($_GET['post_id']);?>&mid=<?php echo base64_encode($strValue['id'])?>">Payment</a>
                                               <?php elseif($strValue['status']==3):?>
                                                    Completed
                                               <?php else:?>
                                                    &nbsp;
                                                <?php endif;?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                            <tr><td colspan="6">No Milestone Found</td></tr>
                            <?php endif;?>
                        </table>
                        </div>
                    </div>
                </div>
                <!----content End----> 
            </div>
        </div>
        <!----mid End----> 
        <!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?> 
<script type="text/javascript">
function job_done(post_id){
	if(confirm('Are you sure?')){
		var url=window.location.href+'&job_id='+post_id;
		window.location.href=url;
		return true;
	}
	else{
		 var prim = document.getElementById("checking");
		 prim.checked = false;
		 return false;
	}
	
}
</script>	
    </body>
</html>