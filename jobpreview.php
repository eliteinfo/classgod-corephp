<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
if ($_GET['jobId'] != '')
{
    $strSql = "SELECT tp.*,tc.name as maincat,ts.sname as subcname,tu.Username FROM 
                        tbl_post tp 
                        INNER JOIN tbl_users tu ON tu.Id = tp.uid
                        LEFT JOIN tbl_category tc ON tc.id = tp.category_id
                        LEFT JOIN tbl_subcategory ts on ts.sid = tp.sub_cat where tp.id = '".$_GET['jobId']."'  GROUP BY tp.id ";
    $arrData  = $objModule->getAll($strSql);
    if($_SESSION['clg_userid']!=$arrData[0]['uid'])
    {
         $objModule->redirect("./dashboard-buyer.php");
    }
    $arrAtatch = $objModule->getAll("SELECT * FROM tbl_post_attach WHERE post_id = '".$_GET['jobId']."' ");
}
if($_POST['btnPost']!='')
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_post","id");
    $objData->setFieldValues("status",'0');
    $objData->setWhere("id = '".$_GET['jobId']."' ");
    $objData->update();
    unset($objData);
    $objModule->setMessage("Your job is under review and will be published shortly on the site.","success");
    $objModule->redirect("./dashboard-buyer.php");
}
$arrCategory = $objModule->getCategory();
$arrUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Status = '1' AND User_type = '1' ");
$arrTempSkills = $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");
foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
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
    <body>
        <!----Top Start---->
        <?php include('includes/header_top.inc.php'); ?>
        <!----Top End----> 
        <!----header Start---->
        <div class="header">
            <ul class="slides">
                <li>
                    <div class="header_main">
                        <div class="header_img"><img src="images/about_inner.jpg" alt="" /></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Post an assignment </h1>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="mid">   
            <div class="wrapper"> 
                <!----content Start---->
                <div class="content_part">
                    <div class="creat_acct job-prev">
                        	<div class="jp-row">
                            	<div class="jp-left">Job Title : </div>
                                <div class="jp-right"><?php echo $arrData[0]['title'];?></div>
                            </div>
                            <div class="jp-row">
                            	<div class="jp-left">Job Description : </div>
                                <div class="jp-right"><?php echo $arrData[0]['description'];?></div>
                            </div>
                            <div class="jp-row">
                            	<div class="jp-left">Files : </div>
                                <div class="jp-right">
                                	<?php if(!empty($arrAtatch)): ?>
			                                <?php foreach($arrAtatch as $intKey=>$strValue):?>
			
			                                    <?php if(file_exists("upload/attachment/".$strValue['post_id']."/".$strValue['filename']) && $strValue['filename']!=''):
                                                                
                                                                $strEx = strtolower(pathinfo("upload/attachment/".$strValue['post_id']."/".$strValue['filename'],PATHINFO_EXTENSION));
                                                                ?>
                                                                    
                                                                    <a target="_blank" href="<?php echo $objModule->SITEURL;?>upload/attachment/<?php echo $strValue['post_id'];?>/<?php echo $strValue['filename'];?>" class="jp-sprite <?php echo $objModule->getClass($strEx);?>"><?php echo $strValue['filename'];?></a>
			
			                                            <br/>
			
			                                     <?php endif;?>
			
			                                <?php endforeach;?>
			
			                        <?php else:?>
			
			                            No files found.
			
			                        <?php endif;?>
                                </div>
                            </div>
                            <div class="jp-row">
                            	<div class="jp-left">Price : </div>
                                <div class="jp-right"><?php echo $arrData[0]['price'];?></div>
                            </div>
                            <div class="jp-row">
                            	<div class="jp-left">Category : </div>
                                <div class="jp-right"><?php echo $arrData[0]['maincat'];?></div>
                            </div>
                            <div class="jp-row">
                            	<div class="jp-left">Sub Category : </div>
                                <div class="jp-right"><?php echo $arrData[0]['subcname'];?></div>
                            </div>
                            <?php if($arrData[0]['skills']!=''):?>
                            <div class="jp-row">
                            	<div class="jp-left">Skills : </div>
                                <div class="jp-right"><?php 
                                $arrS = array();
                                $arrS = @explode(',',$arrData[0]['skills']);
                                foreach($arrS as $intS=>$strS):
                                 $strS1 .= ucfirst($arrSkill[$strS]).' ,';
                                endforeach;
                                echo trim($strS1,',');?></div>
                            </div>
                            <?php endif;?>
                            <div class="jp-row">
                            	<div class="jp-left">End Date : </div>
                                <div class="jp-right"><?php echo date("d M Y",strtotime($arrData[0]['end_date_time']));?></div>
                            </div>
                            <div class="jp-row mrgtop10" align="center">
                            	<form method="post" action="">
                                        <input type="submit" class="jp-btn" name="btnPost" value="Post This Job"/>
                                        <a href="<?php echo $objModule->SITEURL;?>edit_post.php?jobId=<?php echo $_GET['jobId'];?>" class="jp-btn">Edit Post</a>
                                    </form>
                            </div>
                        <div class="clear"></div>
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
<script type="text/javascript">
    function getSubcat(intCat, intSelect)
    {
        jQuery.ajax({
            url: 'ajax.php',
            data: {intSelect: intSelect, intCat: intCat, CMD: "GET_SUBCATEGORY"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                var arrSk = data.split('~~~~');
                jQuery("#subCat").html(arrSk[0]);
                jQuery("#cmbSkills").html(arrSk[1]);
            }
        });
    }
    function addFile()
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        if (intCnt == 10 || intCnt > 10)
        {
            alert("Maximum 10 files allowed");
            return false;
        }
        jQuery.ajax({
            url: 'ajax.php',
            data: {CMD: "ADD_FILE"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                jQuery("#filegroup").append(data);
                jQuery("#hdnFileCnt").val(intCnt + 1);
            }
        });
    }
    function removeFile(strObj)
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        jQuery(strObj).parent("div.files").remove();
        jQuery("#hdnFileCnt").val(intCnt - 1);
    }
    jQuery(function () {
        jQuery("#datepicker").datepicker({
            minDate: 1
        });
    });
</script>    