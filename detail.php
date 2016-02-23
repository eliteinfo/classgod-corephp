<?php
include 'lib/module.php';
if($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if($_SESSION['clg_usertype']==0)
{
    // redirect to tutor dashboard
    $objModule->redirect("./buydashboard.php");
}
$arrTempSkills  =   $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");
foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
}
$arrPost = $objModule->getAll("SELECT * From tbl_post WHERE id = '".$_GET['pid']."' ");
if(empty($arrPost))
{
    $objModule->redirect("./tutordashboard.php");
}

if($_POST['btnBid']!='')
{
    
    if($_POST['txtDescription']!='' && $_POST['txtAmount']!='')
    {
        $objData = new PCGData();
        $objData->setTableDetails("tbl_bidding","Id");
        $objData->setFieldValues("Post_id",$_GET['pid']);
        $objData->setFieldValues("Uid",$_SESSION['clg_userid']);
        $objData->setFieldValues("Bid_amt",$_POST['txtAmount']);
        $objData->setFieldValues("Description",$_POST['txtDescription']);
        $objData->setFieldValues("create_at",date("Y-m-d H:i:s"));
        $objData->insert();
        unset($objData);
        
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
    </head>
    <body class="home">
        <!----Top Start---->
        <?php include('includes/header_top.inc.php'); ?>
        <!----Top End----> 
        <!----header Start---->
        <div align="center">
            <div>
                <h1><?php echo $arrPost[0]['title'];?></h1>
                <p>Posted on : <?php echo $objModule->timeDiff($arrPost[0]['created_date'], date("Y-m-d H:i:s")); ?></p>
                <p>Budget : $ <?php echo $arrPost[0]['price'];?></p>
                <p>Time left : <?php echo $objModule->timeLeft(date("Y-m-d H:i:s"),$arrPost[0]['end_date_time']); ?></p>
                <p>Description : <?php echo $arrPost[0]['description']; ?></p>
                <?php if($arrPost[0]['skills']!=''):
                    $arrS = @explode(',', $arrPost[0]['skills']);
                    ?>
                <p>Desired Skills: 
                <?php 
                 foreach($arrS as $intKey=>$strVal):
                       $str .= $arrSkill[$strVal['sk_id']].',';
                 endforeach;
                 echo trim($str,',');
                 ?>
                </p>
                <?php endif;?>
            </div>
        </div>
        <h1>Create Your Proposal</h1>
        <form method="post" name="frmBidding" id="frmBidding" onsubmit="return frmvalidate(this.id);">
            <textarea name="txtDescription" class="required" placeholder="Description"></textarea>
            <input type="text" name="txtAmount" class="required onlynumber" placeholder="Amount"/>
            <input type="submit" name="btnBid"  value="Submit" />
        </form>
        <div class="clear">&nbsp;</div>
        <h1>Proposals</h1>
        
        <!----mid End----> 
        <!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?>
    </body>
</html>    