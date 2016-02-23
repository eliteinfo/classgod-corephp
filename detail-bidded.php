<?php
include 'lib/module.php';
include 'lib/unplagapi.class.php';
define('API_KEY', 'XqM1dBpDN8rYPEtu');
define('API_SECRET', 'I7QpcjZeomzMVwERfAWK58tsb2LPvGxr');
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if (isset($_GET['post_id']) && $_GET['post_id'] == "")
{
    if (isset($_GET['post_uid']) && $_GET['post_uid'] == "")
    {
        $objModule->redirect("./search_jobs.php");
    }
}
$arrExistBid = $objModule->getAll("SELECT * FROM tbl_bidding WHERE Uid = '" . $_SESSION['clg_userid'] . "' AND Post_id = '" . $_GET['post_id'] . "' ");
if (empty($arrExistBid))
{
    $objModule->redirect("./tutordashboard.php");
}
if ($_POST['btnBidPost'] != '')
{
    if ($_POST['bid_deliverydate'] != '' && $_POST['bid_amount'] != '' && $_POST['hdnBid'] != '')
    {
        $current_date = date('Y-m-d H:i:s');
        $strDelivery = date("Y-m-d", strtotime($_POST['bid_deliverydate']));
        $intBid = $_POST['hdnBid'];
        $strUpdate = "UPDATE tbl_bidding SET Bid_amt = '" . $_POST['bid_amount'] . "',Description='" . $_POST['txtBidDesc'] . "',delivery_date='" . $strDelivery . "',status = '1' WHERE Post_id = '" . $_POST['hdn_postid'] . "' AND  Uid = '" . $_SESSION['clg_userid'] . "' ";
        $arrUpdate = $objModule->getAll($strUpdate);


        /* Notification inserted */
        $insert_not_bidother = "INSERT INTO tbl_notification (Id, post_id, From_userId, To_userId, Ntype, Ndate, Status) VALUES (NULL,'" . $_POST['hdn_postid'] . "','" . $_SESSION['clg_userid'] . "','" . $_POST['hdn_posterid'] . "',3,'" . $current_date . "',0)";
        $db_not_decl = $objModule->getAll($insert_not_bidother);
        /* send mail to buyer */
        $arrPostUSer = $objModule->getAll("SELECT * FROM tbl_users WHERE Id='" . $_POST['hdn_posterid'] . "'");
        $arrBidUser = $objModule->getAll("SELECT Username FROM tbl_users WHERE Id='" . $_SESSION['clg_userid'] . "'");
        $to = $arrPostUSer[0]['Email'];
        $subject = "Notification for Update Bid of Job ";
        $arrBidUser = $objModule->getAll("SELECT Username FROM tbl_users WHERE Id='" . $_SESSION['clg_userid'] . "'");
        $to = $arrPostUSer[0]['Email'];
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
								<h2>Update bid on your post !</h2>
								<br />
								<div class="textdark">
									<strong>Dear ' . ucfirst($arrPostUSer[0]['Username']) . ',</strong><br/>
									' . ucfirst($arrBidUser[0]['Username']) . ' has update bid on your job ' . strtoupper($_REQUEST['hdn_posttitle']) . '
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
        if (mail($to, $subject, $strMessage, $headers))
        {
            $objModule->setMessage("Bid update successfully", "success");
            $objModule->redirect("./tutordashboard.php");
        }
    }
}
if ($_POST['btnWithdraw'] != '')
{
    if ($_POST['hdnBid'] != '' && $_POST['hdn_postid'] != '')
    {
        $arrCh = $objModule->getAll("SELECT COUNT(*) AS tchec FROM tbl_bidding WHERE Id = '" . $_POST['hdnBid'] . "' AND Post_id = '" . $_POST['hdn_postid'] . "'");
        if ($arrCh[0]['tchec'] > 0)
        {
            $objData = new PCGData();
            $objData->setTableDetails("tbl_bidding", "Id");
            $objData->setWhere("Id = '" . $_POST['hdnBid'] . "' AND Post_id = '" . $_POST['hdn_postid'] . "'  ");
            $objData->delete();
            unset($objData);

            $objData = new PCGData();
            $objData->setTableDetails("tbl_notification", "Id");
            $objData->setWhere("post_id = '" . $_POST['hdn_postid'] . "' AND From_userId = '" . $_SESSION['clg_userid'] . "' AND To_userId = '" . $_POST['hdn_posterid'] . "' AND Ntype IN (1,3) ");
            $objData->delete();
            unset($objData);

            $objModule->setMessage("Bid delete successfully", "success");
        }
        else
        {
            $objModule->setMessage("No bid found", "error");
        }
    }
    $objModule->redirect("./tutordashboard.php");
}
/* add milestone code */
if ($_POST['btnAddMilestone'] != '')
{
    $intCost = array_sum($_POST['cost']);
    if ($intCost > $_POST['hdnAmt'])
    {
        $objModule->setMessage("Milestone cost is greater than bid amount remove <br />some milestone or change the cost", "error");
    }
    else
    {
        $arrPostUSer = $objModule->getAll("SELECT * FROM tbl_users WHERE Id='" . $_POST['hdn_posterid'] . "'");
        $arrBidUser = $objModule->getAll("SELECT Username FROM tbl_users WHERE Id='" . $_SESSION['clg_userid'] . "'");

        $strHtml = '';
        $arrExisMile = $objModule->getAll("SELECT COUNT(*) AS tcnt FROM tbl_milestone WHERE (status = '0' or  status = '2') AND post_id = '" . $_POST['hdn_postid'] . "' AND uid = '" . $_SESSION['clg_userid'] . "'  ");
        if ($arrExisMile[0]['tcnt'] > 0)
        {
            $objModule->getAll("DELETE FROM tbl_milestone WHERE (status = '0' or status = '2')  AND post_id = '" . $_POST['hdn_postid'] . "' AND uid = '" . $_SESSION['clg_userid'] . "'  ");
            //echo "<pre>";print_r($objModule);die;
            $objModule->getAll("DELETE FROM tbl_notification WHERE post_id = '" . $_POST['hdn_postid'] . "' AND From_userId = '" . $_SESSION['clg_userid'] . "' AND  To_userId = '" . $arrPostUSer[0]['Id'] . "' AND Ntype = '8'");
        }

        foreach ($_POST['cost'] as $intKey => $strValue):
            if ($strValue != '' && $_POST['hdnStatus'][$intKey] == 0)
            {
                $objData = new PCGData();
                $objData->setTableDetails("tbl_milestone", "id");
                $objData->setFieldValues("post_id", $_GET['post_id']);
                $objData->setFieldValues("uid", $_SESSION['clg_userid']);
                $objData->setFieldValues("created_at", date("Y-m-d H:i:s"));
                $objData->setFieldValues("status", '0');
                $objData->setFieldValues("edate", date("Y-m-d", strtotime($_POST['edate'][$intKey])));
                $objData->setFieldValues("cost", $strValue);
                $objData->setFieldValues("title", $_POST['title'][$intKey]);
                $objData->insert();
                $intMId = $objData->intLastInsertedId;
                unset($objData);

                if ($intMId != '')
                {
                    $strHtml .='<tr>
                                    <td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . ($intKey + 1) . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . $_POST['title'][$intKey] . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . $strValue . '</td>
                                    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">' . date("d M Y", strtotime($_POST['edate'][$intKey])) . '</td>
                                </tr>';
                }
            }
            else
            {
                continue;
            }
        endforeach;

        /* Notification to buyer that milestone added by tutor */
        if($intMId!='')
        {
            $objData = new PCGData();
            $objData->setTableDetails("tbl_notification", "Id");
            $objData->setFieldValues("post_id", $_POST['hdn_postid']);
            $objData->setFieldValues("From_userId", $_SESSION['clg_userid']);
            $objData->setFieldValues("To_userId", $_POST['hdn_posterid']);
            $objData->setFieldValues("Ntype", '8');
            $objData->setFieldValues("Ndate", date("Y-m-d H:i:s"));
            $objData->setFieldValues("Status", 0);
            $objData->insert();
            $intNId = $objData->intLastInsertedId;
            unset($objData);
        }
        //echo "<pre>";print_r(34354);die;
        if ($intNId != '' && $intMId!='')
        {

            $strTo = $arrPostUSer[0]['Email'];
            $strSubject = "Milestone added on your post " . $_REQUEST['hdn_posttitle'];
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
											<img src="'.$objModule->SITEURL.'images/fb_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="'.$objModule->SITEURL.'images/tw_icon2.png"  width="30px" height="30px" alt="social icon"/>
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
								<h2>Milestone added on your post !</h2>
								<br />
								<div class="textdark">
									<strong>Dear ' . ucfirst($arrPostUSer[0]['Username']) . ',</strong><br /><br />
									' . $arrBidUser[0]['Username'] . ' added  milestone for the post <br/>' . $_REQUEST['hdn_posttitle'] . '<br/>
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
                    <tbody>'.$strHtml.'</tbody>                            
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
            mail($strTo, $strSubject, $strMessage, $headers);
        }

        $objModule->redirect("./detail-bidded.php?post_id=" . $_GET['post_id'] . "&job=act&post_uid=" . $_GET['post_uid']);
    }
}
if ($_POST['btnUploadFile'] != '')
{
    if ($_FILES['txtFile']['name'] != '')
    {
        $arrEx = array("doc", "docx", "txt");
        $strEx = strtolower(pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION));
        if (!in_array($strEx, $arrEx))
        {
            $objModule->setMessage("Please upload doc or txt file", "error");
            /* $objModule->redirect("./detail-bidded.php?post_id=".$_GET['post_id']."&job=act&post_uid=".$_GET['post_uid']); */
        }
        else
        {
            $strFilename = uniqid() . "." . $strEx;
            if (move_uploaded_file($_FILES['txtFile']['tmp_name'], "upload/assignment/" . $strFilename))
            {
                $strContent = file_get_contents("upload/assignment/".$strFilename);
                $un_api = new UnApi(API_KEY, API_SECRET);

                $file_resp = $un_api->UploadFile('docx', $strContent);
                if($file_resp['result'])
                {
                    $check_resp = $un_api->Check('web', $file_resp['file_id']);
                    if($check_resp['result'])
                    {
                        $objData = new PCGData();
                        $objData->setTableDetails("tbl_assignment", "id");
                        $objData->setFieldValues("mid", $_POST['hdnMileId']);
                        $objData->setFieldValues("post_id", $_POST['hdn_postid']);
                        $objData->setFieldValues("uid", $_SESSION['clg_userid']);
                        $objData->setFieldValues("filename", $strFilename);
                        $objData->setFieldValues("check_id", $check_resp[0]['check_id']);
                        $objData->setFieldValues("file_id", $file_resp['file_id']);
                        $objData->insert();
                        $objModule->setMessage("Document uplaod successfully and under review", "success");
                        $objModule->redirect("./detail-bidded.php?post_id=" . $_GET['post_id'] . "&job=act&post_uid=" . $_GET['post_uid']);
                    }
                }
                else
                {
                    $objModule->setMessage("There is error in system for checking file", "error");
                }
            }
        }
    }
}
$arrPostDetail = $objModule->getAll("select p.id, p.category_id, p.title, p.uid, p.start_date_time, p.end_date_time, p.description, p.win_date, p.win_uid, p.price, p.win_status, p.created_date, p.zipcode,u.Photo, u.Status, u.User_type, u.Creation_date,c.name from tbl_post p,tbl_users u,tbl_category c WHERE u.id=p.uid AND p.id='" . $_GET['post_id'] . "' AND c.id=p.category_id");
$arrClientPost = $objModule->getAll("SELECT COUNT(*) AS tpcnt FROM tbl_post WHERE uid = '" . $_GET['post_uid'] . "' ");
$intRate = 0;
$arrRating = $objModule->getAll("SELECT AVG(review_rate) as avgrate FROM tbl_reviews WHERE review_to = '" . $_GET['post_uid'] . "'  ");
if ($arrRating[0]['avgrate'] != '')
    $intRate = $arrRating[0]['avgrate'];
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
                    timepicker: false,
                    format: 'd-m-Y',
                    minDate: '+1970/01/01',
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
                                <?php if($arrPostDetail[0]['win_status']=='0'){?>
                                <h1>Bid Details</h1>
                                <?php } else {  ?>
                                    <h1>Classroom</h1>
                                <?php  } ?>
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
                                    <div class="regform" id="bidform" style="display: block;">

                                        <form action="" id="frmBid" method="post" onsubmit="return frmvalidate(this.id);">
                                            <?php if ($_GET['job'] == 'bid'): ?>
                                                <div class="row">
                                                    <div class="one_full"><label>Enter Description:</label>
                                                        <textarea class="required" name="txtBidDesc"><?php echo stripslashes($arrExistBid[0]['Description']); ?></textarea></div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Bid Amount:</label>
                                                        <input class="onlynumber required" value="<?php echo $arrExistBid[0]['Bid_amt']; ?>" name="bid_amount" kl_virtual_keyboard_secure_input="on" type="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Estimate Delivery Date:</label>
                                                        <input class="required" id="datetimepicker3" value="<?php echo date("d-m-Y", strtotime($arrExistBid[0]['delivery_date'])); ?>" name="bid_deliverydate"  type="text" />
                                                    </div>
                                                </div>
                                                <?php if ($arrPostDetail[0]['win_status'] == 0): ?>
                                                    <div class="row sbmt">
                                                        <div class="one_full">
                                                            <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                                            <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                                            <input type="hidden" id="hdnBid" name="hdnBid" value="<?php echo $arrExistBid[0]['Id']; ?>" />
                                                            <input type="hidden" id="hdn_posttitle" name="hdn_posttitle" value="<?php echo $arrPostDetail[0]['title']; ?>" />
                                                            <input value="Update Bid" name="btnBidPost" type="submit" />
                                                            <input value="Withdraw" name="btnWithdraw" type="submit" />
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Bid Amount:</label>
                                                        $ <?php echo $arrExistBid[0]['Bid_amt']; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Estimate Delivery Date:</label>
                                                        <?php echo date("d M Y", strtotime($arrExistBid[0]['delivery_date'])); ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Description:</label>
                                                        <?php echo stripslashes($arrExistBid[0]['Description']); ?>
                                                    </div>
                                                </div>

                                                <?php if ($arrPostDetail[0]['win_status'] != 1 && $arrPostDetail[0]['win_status'] != 4): ?>
                                                    <a href="detail-bidded.php?post_id=<?php echo $_GET['post_id']; ?>&job=bid&post_uid=<?php echo $_GET['post_uid']; ?>" class="round-btn2">Update Bid</a>
                                                    <div class="row sbmt">
                                                        <div class="one_full">
                                                            <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                                            <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                                            <input type="hidden" id="hdnBid" name="hdnBid" value="<?php echo $arrExistBid[0]['Id']; ?>" />
                                                            <input value="Withdraw" name="btnWithdraw" type="submit" />
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar_box">
                                <ul class="icon-list2">
                                    <li><div class="icn"><span><i class="fa fa-star"></i></span></div><div class="tit"><strong><?php echo number_format((float) $intRate, 1, '.', ''); ?></strong><img src="images/gold_star/star_<?php echo $objModule->roundDownToHalf($intRate); ?>.png"</div></li>                                    
                                    <li>
                                        <div class="icn"><span><i class="fa fa-edit"></i></span></div>
                                        <div class="tit"><strong><?php echo date("d,  M Y", strtotime($arrPostDetail[0]['created_date'])); ?></strong><br>Posted on</div>
                                    </li>
                                    <li>
                                        <div class="icn"><span><i><img alt="" src="images/icon18.png"></i></span></div>
                                        <div class="tit"><strong><?php echo $arrClientPost[0]['tpcnt']; ?></strong>Job Posted</div>
                                    </li>
                                    <li>
                                        <div class="icn"><span><i class="fa fa-tint"></i></span></div>
                                        <div class="tit"><strong><?php
                                                $strCur = strtotime(date("Y-m-d H:i:s"));
                                                $strEnd = strtotime($arrPostDetail[0]['end_date_time']);
                                                if ($strEnd > $strCur)
                                                {
                                                    $diff = $strEnd - $strCur;
                                                    $intDays = round($diff / 86400);
                                                }
                                                if ($intDays > 0)
                                                {
                                                    echo $intDays;
                                                }
                                                else if ($intDays == 0)
                                                {
                                                    echo 1;
                                                }
                                                else
                                                {
                                                    echo 0;
                                                }
                                                ?></strong>Days Left</div>
                                    </li>
                                    <li>
                                        <div class="icn"><span><i class="fa fa-edit"></i></span></div>
                                        <div class="tit"><strong><?php echo date("d,  M Y", strtotime($arrPostDetail[0]['end_date_time'])); ?></strong><br>Due date</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><?php echo $arrPostDetail[0]['title']; ?></h2>
                        <div class="post_date"><div class="pm"><strong>Posted on:</strong> <?php echo date("d,  M Y", strtotime($arrPostDetail[0]['created_date'])); ?></div><div class="pm"><strong>Category:</strong> <?php echo $arrPostDetail[0]['name']; ?></div>
                            <div class="blog_price">
                                <ul>
                                    <li>Est. Budget</li>
                                    <?php if ($arrPostDetail[0]['price'] != '' && $arrPostDetail[0]['price'] != 0): ?>
                                        <li>$<span class="money">10</span></li>
                                    <?php else: ?>
                                        <li><span class="money">N/A</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="pro_detail">
                            <?php echo $arrPostDetail[0]['description']; ?>
                        </div><div class="clear"></div>
                    <div class="pro_detail">
                        <a href="messages_detail.php?from=<?php echo $_SESSION['clg_userid']; ?>&to=<?php echo $_REQUEST['post_uid'];?>&post_id=<?php echo $_REQUEST['post_id']; ?>">Message Room</a>
                    </div>
                        <?php if(!empty($arrPostAttach)): ?>
                        <ul class="attach-list">

                                <?php
                                $l=0;
                                foreach($arrPostAttach as $intK=>$strV): ?>
                                    <?php if(file_exists("upload/attachment/".$strV['post_id']."/".$strV['filename']) && $strV['filename']!=''):
                                        if($l==0) {
                                            ?>
                                            <h3>Attachments:</h3><br>
                                        <?php
                                        }

                                                $strEx = strtolower(pathinfo("upload/attachment/".$strV['post_id']."/".$strV['filename'],PATHINFO_EXTENSION));?>
                                                    <li><a download target="_blank" href="<?php echo $objModule->SITEURL;?>upload/attachment/<?php echo $strV['post_id'];?>/<?php echo $strV['filename'];?>" class="jp-sprite <?php echo $objModule->getClass($strEx);?>"><p style="font-size:18px;margin-top:0px;"><span><?php echo $strV['filename'];?></span></p></a></li>
                                   <?php endif;?>

                                <?php
                                $l++;
                                endforeach;?>
                        </ul>                                            
                        <?php endif;?>
                        <div class="regform det-bid">
                            <?php echo $objModule->getMessage(); ?>
                            <?php
                            if ( ($arrPostDetail[0]['win_status'] == 1 || $arrPostDetail[0]['win_status'] == 4) && $arrPostDetail[0]['win_uid'] == $_SESSION['clg_userid'] && $_SESSION['clg_usertype'] == 1)
                            {
                                $arrMilestone = $objModule->getAll("SELECT * FROM tbl_milestone WHERE post_id = '" . $_GET['post_id'] . "' and uid = '" . $_SESSION['clg_userid'] . "' ");
                                ?>
    <?php if (empty($arrMilestone)): ?>
                                    <?php if($arrPostDetail[0]['win_status']!=4): ?>
                                    <a href='javascript:;' onclick='addMilestone();'>
                                        <i class="fa fa-plus-circle"></i> Add Milestone
                                    </a>
                                    <br />
                                    <h3>Milestone:</h3>
                         <form method="POST" name="frmMilestone" id="frmMilestone" onsubmit="return chkAmnt();">
                                        <ul id="filegroup"></ul>
                                        <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                        <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                        <input type='hidden' name='hdnAmt' id='hdnBidAmt' value='<?php echo $arrExistBid[0]['Bid_amt']; ?>' />
                                        <input type="hidden" id="hdnCnt" name="hdnCnt" value="0" />
                                        <input type="submit" name="btnAddMilestone" value="Save" onclick="return frmvalidate('frmMilestone');"/>
                                    </form>
                                    <?php endif;?>
    <?php else: ?>
                                <h3>Milestone:</h3><br>
                                    <form method="POST" name="frmMilestone" id="frmMilestone" onsubmit="return chkAmnt();">
                                        <ul id="filegroup">
                                            <div class="edt">
                                                <?php if($arrPostDetail[0]['win_status']!=4): ?>
                                                <a href='javascript:;' onclick='addMilestone();'>
                                                    <i class="fa fa-plus-circle"></i> Add Milestone</a>
                                                </a>
                                                <?php endif;?>
                                            </div>
                                            <br />
                                            <?php $inthdnCnt = 1;
                                            foreach ($arrMilestone as $intKeys => $strVal):
                                                ?>
            <?php if ($strVal['status'] == 0): ?>
                                            <li class='files' id='filediv<?php echo $inthdnCnt; ?>'>
                                                <div class="fas">
                                                    <input type='text' placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title']; ?>"/>
                                                </div>

                                                <div class="cn">
                                                    <input type='text' placeholder='Cost' onblur='return chkAmnt();' name='cost[]' value='<?php echo $strVal['cost']; ?>'  class='required cost onlynumber'/>
                                                </div>
                                                <div class="dt">
                                                    <input type='text' placeholder='Estimate Delivery Date' class='datetimepicker3 required' name='edate[]' value='<?php echo date("d-m-Y", strtotime($strVal['edate'])); ?>'/>

                                                </div>
                                                <input type="hidden" name="hdnStatus[]" value="0" />
                                                <div class="edt">
                                                    <?php if ($strVal['status'] == 0): ?>
                                                        <a href='javascript:;' onclick='removeMilestone(this);' class="icnbtn"><i class="fa fa-minus-circle"></i></a>
                                                    <?php endif; ?>
                                                    <?php elseif ($strVal['status'] == 1):
                                                    ?>
                                                    <li class='files readonly' id='filediv<?php echo $inthdnCnt; ?>'>
                                                        <div class="fas">
                                                            <input type='text' readonly placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title']; ?>"/>
                                                        </div>
                                                        <div class="cn">
                                                            <input type='text' readonly placeholder='Cost' onblur='return chkAmnt();'  name='cost[]' value='<?php echo $strVal['cost']; ?>'  class='required cost onlynumber'/>
                                                        </div>
                                                        <div class="dt">
                                                            <input type='text' readonly placeholder='Estimate Delivery Date' class=' required' name='edate[]' value='<?php echo date("d-m-Y", strtotime($strVal['edate'])); ?>' />

                                                        </div>
                                                        <input type="hidden" name="hdnStatus[]" value="1" />
                                                        <div class="edt">
                                                            <?php if ($strVal['status'] == 0): ?>
                                                                <a href='javascript:;' onclick='removeMilestone(this);' class="icnbtn"><i class="fa fa-minus-circle"></i></a>
                                                            <?php endif; ?>
                                                            <div class="msg success">Accepted</div>
                                                            <a class="icnbtn sug_skil" id="data_<?php echo $strVal['id']; ?>" data-attr="<?php echo $strVal['id']; ?>" href="#inline_content">
                                                                <i class="fa fa-upload">

                                                                </i>
                                                            </a>

                                                            <?php elseif ($strVal['status'] == 2): ?>
                                                            <li class='files' id='filediv<?php echo $inthdnCnt; ?>'>
                                                                <div class="fas">
                                                                    <input type='text'  placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title']; ?>"/>
                                                                </div>
                                                                <div class="cn">
                                                                    <input type='text'  placeholder='Cost' onblur='return chkAmnt();'  name='cost[]' value='<?php echo $strVal['cost']; ?>'  class='required cost onlynumber'/>
                                                                </div>
                                                                <div class="dt">
                                                                    <input type='text'  placeholder='Estimate Delivery Date' class='required' name='edate[]' value='<?php echo date("d-m-Y", strtotime($strVal['edate'])); ?>' />

                                                                </div>
                                                                <input type="hidden" name="hdnStatus[]" value="0" />
                                                                <div class="edt">
                                                                    <div class="msg fail">Rejected</div>
                                                                    <?php elseif ($strVal['status'] == 3): ?>
                                                                    <li class='files readonly' id='filediv<?php echo $inthdnCnt; ?>'>
                                                                        <div class="fas">
                                                                            <input type='text' readonly  placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title']; ?>"/>
                                                                        </div>
                                                                        <div class="cn">
                                                                            <input type='text'  placeholder='Cost' onblur='return chkAmnt();' readonly  name='cost[]' value='<?php echo $strVal['cost']; ?>'  class='required cost onlynumber'/>
                                                                        </div>
                                                                        <div class="dt">
                                                                            <input type='text'  placeholder='Estimate Delivery Date' class='required' readonly name='edate[]' value='<?php echo date("d-m-Y", strtotime($strVal['edate'])); ?>' />

                                                                        </div>
                                                                        <div class="edt">
                                                                            <input type="hidden" name="hdnStatus[]" value="1" />
                                                                            <div class="msg fail">Funded by Client</div>
                                                                            <?php if($strVal['is_req']==0): ?>
                                                                                <a  class="icnbtn iframe" href="payment_request.php?mId=<?php echo base64_encode($strVal['id']);?>" type="button"><i class="fa fa-cc-paypal"></i></a>
                                                                            <?php endif;?>
                                                                            <?php endif; ?>



                                                                        </div>
                                                                    </li>
                                                                    <?php $inthdnCnt++;
                                                                    endforeach; ?>
                                        </ul>
                                        <?php if($arrPostDetail[0]['win_status']!=4): ?>
                                            <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                            <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                            <input  type='hidden' name='hdnAmt' id='hdnBidAmt' value='<?php echo $arrExistBid[0]['Bid_amt']; ?>' />
                                            <input type="hidden" id="hdnCnt" name="hdnCnt" value="<?php echo count($arrMilestone); ?>" />
                                            <input type="submit" name="btnAddMilestone" value="Update" onclick="return frmvalidate(this.id);"/>
                                        <?php endif;?>
                                    </form>
                            <?php endif; ?>
<?php } ?>
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
                                        <div style="display: none;" id="inline_content">
                                            <div class="popup-cont">
                                                <form onsubmit="return frmvalidate(this.id);" name="frmAddskill" id="frmUploadfile" action="" method="POST" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="one_full">
                                                            <input type="file" id="txtFile" name="txtFile" class="required" onchange="checkExt();" />
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row last">
                                                        <div class="one_full">
                                                            <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                                            <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                                            <input type="hidden" value="" name="hdnMileId" id="hdnMileId" />
                                                            <input type="submit" name="btnUploadFile" value="Upload" />
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                            
                                        <script type="text/javascript">
                                            function addMilestone()
                                            {
                                                var intCnt = parseInt(jQuery("#hdnCnt").val());
                                                jQuery.ajax({
                                                    url: 'ajax.php',
                                                    data: {CMD: "ADD_MILESTONE", intCnt: intCnt},
                                                    type: 'POST',
                                                    success: function (data)
                                                    {
                                                        jQuery("#filegroup").append(data);
                                                        jQuery("#hdnCnt").val(intCnt + 1);
                                                        inti();

                                                    }
                                                });
                                            }
                                            function removeMilestone(strObj)
                                            {
                                                var intCnt = parseInt(jQuery("#hdnCnt").val());
                                                jQuery(strObj).parents("li.files").remove();
                                                jQuery("#hdnCnt").val(intCnt - 1);
                                            }
                                            function inti()
                                            {
                                                jQuery('.datetimepicker3').datetimepicker({
                                                    timepicker: false,
                                                    format: 'd-m-Y',
                                                    minDate: '+1970/01/01'
                                                });
                                                jQuery('.datetimepicker3').scrollTop(0);
                                                jQuery(".onlynumber").keyup(function (e)
                                                {
                                                    if (/\D/g.test(this.value))
                                                    {
                                                        /* Filter non-digits from input value.*/
                                                        this.value = this.value.replace(/\D/g, '');
                                                    }
                                                });
                                            }
                                            function chkAmnt()
                                            {
                                                var intBidAmt = parseFloat(jQuery("#hdnBidAmt").val());
                                                var intMilstone = 0;
                                                jQuery(".cost").each(function (intKey, strVal) {
                                                    intMilstone = intMilstone + parseFloat(this.value);
                                                });
                                                if (intMilstone > intBidAmt)
                                                {
                                                    alert("Milestone cost is not greater than bid amount \n\
                                                       remove some milestone or change the cost");
                                                    return false;
                                                }
                                            }
                                            function checkExt()
                                            {
                                                var file = document.getElementById("txtFile").files[0];
                                                var filename = file.name;
                                                var extSplit = filename.split('.');
                                                var extReverse = extSplit.reverse();
                                                var ext = extReverse[0];
                                                if (ext === "txt" || ext === "doc" || ext === "docx")
                                                {

                                                }
                                                else
                                                {
                                                    alert('Only text and doc file allowed');
                                                    jQuery("#txtFile").val('');
                                                }
                                            }
                                            function uploadFile()
                                            {
                                                return false;
                                                var strFile=$('#txtFile').val();
                                                
                                                if(strFile!='') 
                                                {
                                                    var file_data = $('#txtFile').prop('files')[0];  
                                                    var form_data = new FormData($("#frmUploadfile")[0]);   
                                                    
                                                    form_data.append('file', file_data);
                                                    $.ajax({
                                                             url: 'upload.php', // point to server-side PHP script 
                                                             dataType: 'text',  // what to expect back from the PHP script, if anything
                                                             cache: false,
                                                             contentType: false,
                                                             processData: false,
                                                             data: form_data,                         
                                                             type: 'post',
                                                             success: function(php_script_response){
                                                                 
                                                                 alert(php_script_response); // display response from the PHP script, if any
                                                             }
                                                  });
                                                }
                                                else
                                                {
                                                    alert("Please upload valid file");
                                                    return false;
                                                }
                                               
                                            }
                                            jQuery(document).ready(function () {
                                                $(".iframe").each(function () {
                                                    jQuery(this).fancybox({
                                                                width : 300,
                                                                height: 500, 
                                                                autoSize : false,
                                                                scrolling : 'no',
                                                                fitToView : true,
                                                                type    :'iframe'
                                                        });
                                                });
                                                
                                                inti();
                                                $(".sug_skil").each(function () {
                                                    var tthis = this;
                                                    $(this).fancybox({
                                                        maxWidth: 300,
                                                        maxHeight: 300,
                                                        fitToView: false,
                                                        width: '70%',
                                                        height: '70%',
                                                        autoSize: true,
                                                        closeClick: false,
                                                        openEffect: 'none',
                                                        closeEffect: 'none',
                                                        beforeLoad: function () {
                                                            jQuery("#hdnMileId").val(jQuery(tthis).attr("data-attr"));
                                                        }
                                                    });
                                                });

                                            });
                                        </script>    