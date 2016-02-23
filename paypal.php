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
if($_SESSION['lid']!='')
{
    $arrCheck = $objModule->getAll("SELECT ttp.*,tp.`title`,tm.`cost`,tm.title as mtitle  FROM 
                                            tbl_temp_payment ttp
                                                    INNER JOIN `tbl_milestone` tm ON tm.`id` = ttp.`mid`
                                                    INNER JOIN `tbl_post` tp ON tp.`id` = ttp.`post_id`
                                    WHERE ttp.id = '".$_SESSION['lid']."' AND tp.`win_status` = '1'
                                    GROUP BY ttp.`id` ");
    if(empty($arrCheck))
    {
       $objModule->redirect("./buyer-milestone.php"); 
    }
    
}
?>
<body style='width: 70%;margin: 0 auto;'>
   <span style='text-align: center;'><p style='margin-top: 20px;border: 1px solid;border-radius: 6px;padding: 8px 25px;'>Please<strong> do not</strong> close the PayPal window until you have been redirected to the thank you confirmation page on our website otherwise your order will not be processed.<br/><br/><br/>Please wait while we redirect you to Paypal...</p></span> 
</body>
<form id="frmpaypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="pixcapp_form">
    <input type="hidden" name="cmd" value="_xclick"/>
    <input type="hidden" name="item_name" value="Assignment"/>
    <input type="hidden" name="amount" value="<?php echo $arrCheck[0]['mcost']; ?>" id="amount"/>
    <input type="hidden" name="business" value="vipul.eng.55-facilitator@gmail.com"/> <!-- vipul.eng.55-facilitator@gmail.com -->
    <input type="hidden" name="notify_url" value="<?php echo $objModule->SITEURL."paypal_notify.php" ?>"/>
    <input type="hidden" name="currency_code" value="USD"/>
    <input type="hidden" name="return" value="<?php echo $objModule->SITEURL."buyer-milestone.php" ?>"/>
    <input type="hidden" name="cancel_return" value="<?php echo $objModule->SITEURL."buyer-milestone.php" ?>"/>
    <input type="hidden" name="custom" value="<?php echo $_SESSION['lid'];?>" />
    <input type="hidden" name="cbt" value="Click here to return to site<?php //echo $homepageUrl; ?>"/>
</form>
<script type="text/javascript">
    document.getElementById("frmpaypal").submit();
</script>