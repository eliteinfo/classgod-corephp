<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
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
if($_POST['btnPayment']!='' && $_POST['post_id']!='' && $_POST['mid']!='')
{
    $objData = new PCGData();
    $objData->setTableDetails("tbl_temp_payment","id");
    $objData->setFieldValues("mid",  base64_decode($_POST['mid']));
    $objData->setFieldValues("post_id",  base64_decode($_POST['post_id']));
    $objData->setFieldValues("uid",$_SESSION['clg_userid']);
    $objData->setFieldValues("description",$_POST['txtNote']);
    $objData->setFieldValues("mcost",$_POST['mcost']);
    if($_POST['btnClosepost']==1)
    {
        $objData->setFieldValues("post_close",'1');
    }
    $objData->insert();
    $intLastId = $objData->intLastInsertedId;
    unset($objData);
    $_SESSION['lid'] = $intLastId;
    echo '<script>window.top.location.href="paypal.php"</script>';
}
$arrPost    =   $objModule->getAll("SELECT tp.*,tm.title as mtitle,tm.cost as mcost FROM `tbl_milestone` tm 
	INNER JOIN tbl_post tp ON tm.`post_id` = tp.`id`
	WHERE tp.`id` = '".base64_decode($_GET['post_id'])."'  AND tm.`id` = '".base64_decode($_GET['mid'])."'  ");

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
            <h2>Make a payment</h2>
            <div class="regform">
                <form   action="" method="POST" name="frmAddskill" id="frmAddSkills" onsubmit="return frmvalidate(this.id);">
                    <div class="row">
                        <div class="one_full">
                            Post Title : <?php echo $arrPost[0]['title'];?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="one_full">
                            Milestone : <?php echo $arrPost[0]['mtitle'];?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="one_full">
                            <input type="text" placeholder="Milestone cost : *" name="mcost" value="<?php echo $arrPost[0]['mcost'];?>" class="onlynumber required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="one_full">
                            <textarea name="txtNote"  placeholder="Add note"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="one_full">
                            <label>
                            <input type="checkbox" name="btnClosepost" value="1" />
                            Is this last milestone ..?
                            </label>
                        </div>
                    </div>
                    <div class="row last">   
                        <div class="one_full">
                            <input type="submit" name="btnPayment" value="Continue" />
                            <input type="hidden" name="post_id"  value="<?php echo $_GET['post_id'];?>" />
                            <input type="hidden" name="mid"  value="<?php echo $_GET['mid'];?>" />
                        </div>	
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>




