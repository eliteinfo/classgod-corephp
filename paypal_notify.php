<?php
include 'lib/module.php';
if ($_REQUEST['custom'] != '' && $_REQUEST['txn_id'] != '')
{
    $arrTempData = $objModule->getAll("SELECT ttp.*,tml.title FROM tbl_temp_payment ttp INNER JOIN tbl_milestone tml ON tml.id = ttp.mid  WHERE ttp.id = '" . $_REQUEST['custom'] . "' ");
    if (!empty($arrTempData))
    {
        $objData = new PCGData();
        $objData->setTableDetails("tbl_milestone_payment", "id");
        $objData->setFieldValues("mid", $arrTempData[0]['mid']);
        $objData->setFieldValues("uid", $arrTempData[0]['uid']);
        $objData->setFieldValues("post_id", $arrTempData[0]['post_id']);
        $objData->setFieldValues("transaction_id", $_REQUEST['txn_id']);
        $objData->setFieldValues("cost", $arrTempData[0]['mcost']);
        $objData->setFieldValues("created_at", date("Y-m-d H:i:s"));
        $objData->insert();
        $intInsert = $objData->intLastInsertedId;
        unset($objData);

        if ($intInsert != '')
        {
            $arrUpdate      =   $objModule->getAll("UPDATE tbl_milestone SET status = '3' WHERE id = '".$arrTempData[0]['mid']."' ");
			/* if($arrTempData[0]['post_close']==1)
            {
                $arrPostupdate  =   $objModule->getAll("UPDATE tbl_post SET win_status = '4',end_date = '".date("Y-m-d H:i:s")."' WHERE id  = '".$arrTempData[0]['post_id']."' ");
            }*/
            
            $arrUser = $objModule->getAll("SELECT tp.*,tu.Username FROM `tbl_post` tp 
                                                INNER JOIN `tbl_users` tu ON tu.`Id` = tp.`uid`
                                    WHERE tp.id = '" . $arrTempData[0]['post_id'] . "' 
                                    GROUP BY tp.`id`  ");
            
            $arrTutor   =   $objModule->getAll("SELECT * FROM tbl_users WHERE id = '".$arrUser[0]['win_uid']."' ");
            
            //send mail to tutor that his milestone payment is done
            
            $strSub = "Payment Done successfully";
            $strTuroTo = $arrTutor[0]['Email'];
            
            $strMess = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        $strMess .='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343; height:52px;">
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
								<h2> Payment Done successfully!</h2>
								<br />
								<div class="textdark">
									<strong>Dear '.$arrTutor[0]['disp_name'].' </strong><br /><br />
									Payment done successfully of your milestone on classgod<br/>
                                                                        <strong>Payment Detail as bellow</strong><br /><br />
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
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Buyer </th>
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Post Title</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Milestone </th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Cost </th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Note </th>
						</tr>
                    </thead>
                    <tbody>    
                        <tr>
                        	<td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrUser[0]['Username'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrUser[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['mcost'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['description'].'</td>
                        </tr>
                        
					</tbody>                            
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
            $headers1 = "MIME-Version: 1.0" . "\r\n";
            $headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers1 .= 'From: ' . $objModule->INFO_MAIL;
            mail($strTuroTo, $strSub, $strMess, $headers1);            
            
            // Send Mail to Admin for payment done
            $strSubject = "Payment Done successfully";
            $strTo = $objModule->INFO_MAIL;
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
								<h2> Payment Done successfully!</h2>
								<br />
								<div class="textdark">
									<strong>Dear Admin</strong><br /><br />
									Payment done successfully of  milestone on classgod<br/>
                                                                        <strong>Payment Detail as bellow</strong><br /><br />
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
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Buyer </th>
                        	<th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Post Title</th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Milestone </th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Cost </th>
                            <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Note </th>
						</tr>
                    </thead>
                    <tbody>    
                        <tr>
                        	<td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrUser[0]['Username'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrUser[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['title'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['mcost'].'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$arrTempData[0]['description'].'</td>
                        </tr>
                        
					</tbody>                            
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
            mail($strTo, $strSubject, $strMessage, $headers);
            
           // $arrDelete = $objModule->getAll("DELETE FROM tbl_temp_payment WHERE id = '".$_REQUEST['custom']."' ");
        }
    }
}
?>