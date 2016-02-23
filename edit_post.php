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
$arrCategory = $objModule->getAll("SELECT * FROM tbl_category ORDER BY name ASC");
if ($_POST['btnPost'] != '')
{
    if ($_POST['txtName'] != '' && $_POST['description'] != '' && $_POST['cmbCategory'] != '' && $_POST['cmbSubCategory'] != '')
    {
        $intPostId = $_GET['jobId'];
        $strEndate = date("Y:m:d H:i:s", strtotime($_POST['end_date']));
        $objData = new PCGData();
        $objData->setTableDetails("tbl_post", "id");
        $objData->setFieldValues("title", $_POST['txtName']);
        $objData->setFieldValues("uid", $_SESSION['clg_userid']);
        $objData->setFieldValues("category_id", $_POST['cmbCategory']);
        $objData->setFieldValues("sub_cat", $_POST['cmbSubCategory']);
        $objData->setFieldValues("start_date_time", date("Y:m:d H:i:s"));
        $objData->setFieldValues("end_date_time", $strEndate);
        $objData->setFieldValues("description", $_POST['description']);
        $objData->setFieldValues("created_date", date("Y:m:d H:i:s"));
        $objData->setFieldValues("price", $_POST['txtAmount']);
        if (!empty($_POST['cmbSkills']))
        {
            $strSkill = @implode(',', $_POST['cmbSkills']);
            $objData->setFieldValues("skills", $strSkill);
        }
        $objData->setWhere("id = '".$_GET['jobId']."' ");
        $objData->update();
        if (!file_exists('./upload/attachment/'.$_GET['jobId'])) {
						mkdir('./upload/attachment/'.$_GET['jobId'], 0755, true);
		}
        unset($objData);
        if (!empty($_FILES['files']['name']))
        {
            foreach ($_FILES['files']['name'] as $intKey => $strVal):
                if($_FILES['files']['name'][$intKey]!='')
                {
					
                    $strEx = pathinfo($_FILES['files']['name'][$intKey], PATHINFO_EXTENSION);
                    //$strFilename = uniqid() . '.' . $strEx;
					$strFilename    =   $_FILES['files']['name'][$intKey];
                    move_uploaded_file($_FILES['files']['tmp_name'][$intKey], "./upload/attachment/".$_GET['jobId']."/" . $strFilename);
                    $objData = new PCGData();
                    $objData->setTableDetails("tbl_post_attach", "att_id");
                    $objData->setFieldValues("post_id", $intPostId);
                    $objData->setFieldValues("filename", $strFilename);
                    $objData->insert();
                }
            endforeach;
        }
        $objModule->redirect("./jobpreview.php?jobId=".$intPostId);
    }
    else
    {
        $objModule->setMessage("Fill all the required fields", "error");
    }
}
if ($_GET['jobId'] != '')
{
    $strSql = "SELECT tp.*,tc.name as maincat,ts.sname as subcname,tu.Username FROM 
                        tbl_post tp 
                        INNER JOIN tbl_users tu ON tu.Id = tp.uid
                        LEFT JOIN tbl_category tc ON tc.id = tp.category_id
                        LEFT JOIN tbl_subcategory ts on ts.sid = tp.sub_cat where tp.id = '".$_GET['jobId']."'  GROUP BY tp.id ";
    $arrData  = $objModule->getAll($strSql);
    $arrAtatch = $objModule->getAll("SELECT * FROM tbl_post_attach WHERE post_id = '".$_GET['jobId']."' ");
    $intAttach = $objModule->intTotalRows;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
            <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="js/script.js"></script>
            <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
            <script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
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
                    
                    $('#datetimepicker3').datetimepicker({
						timepicker: false,
						format: 'd-m-Y',
						minDate: '+1970/01/01',
					});
                    $('#datetimepicker3').scrollTop(0);
                    
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
                                <h1>Edit Job </h1>
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
                    <?php include("includes/buyer_sidebar.inc.php"); ?>
                    <div class="blog_part">
                        <h2><span>Edit Job</span></h2>
                        <div class="regform">
                            <?php echo $objModule->getMessage();?>
                            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="one_full">
                                        <input type="text" name="txtName" class="required" value="<?php echo $arrData[0]['title'];?>" placeholder="Name your job : *" />
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="one_full">
                                        <textarea name="description" class="required" placeholder="Description"><?php echo $arrData[0]['description'];?></textarea><br/>
                                    </div>
                                </div>
                                <div class="row">
                        	<div class="one_full">
                                <div id="filegroup">
                                <?php if(!empty($arrAtatch)): $inCnt=1;?>
                                <?php foreach($arrAtatch as $intKey=>$strValue):?>
                                        
                                    <div class="files">
                                    <?php if(file_exists("upload/attachment/".$strValue['post_id']."/".$strValue['filename']) && $strValue['filename']!=''):
                                        $strEx = strtolower(pathinfo("upload/attachment/".$strValue['post_id']."/".$strValue['filename'],PATHINFO_EXTENSION));?>
                                        <a target="_blank" href="<?php echo $objModule->SITEURL;?>upload/attachment/<?php echo $strValue['post_id'];?>/<?php echo $strValue['filename'];?>" class="jp-sprite <?php echo $objModule->getClass($strEx);?>"><?php echo $strValue['filename'];?></a>
                                     <?php endif;?>
                                        <a onclick="removeAjax(this);" data-attr="<?php echo $strValue['att_id'];?>" href="javascript://" class="remove"></a>
                                    </div>
                                            
                                <?php $inCnt++;endforeach;?>
                                <?php endif;?>    
                                <div class="files" id="showFile">
                                    <input type="file" name="files[]" onchange="checkFile(this);" /> <a href="javascript:;" onclick="addFile();" class="add-more"></a>
                                </div>    
                                </div>
                                </div>
                                </div>
                                <div class="row">
                        	<div class="one_full">
                                <select name="cmbCategory" id="cmbCategory" class="required" onchange="getSubcat(this.value,'','');">
                                    <option value="">-Select the Catagory of Assignment-</option>
                                    <?php foreach ($arrCategory as $intKey => $strValue): ?>
                                        <option <?php if($arrData[0]['category_id']==$strValue['id']): echo "selected"; endif;?> value="<?php echo $strValue['id']; ?>"><?php echo $strValue['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
					</div>
                                </div>					
                                <div class="row">
                        	<div class="one_full">
                                <div id="subCat"></div>
                                </div>
                                </div>
                                <div class="row" id="skill_list">
								</div>
                                <div class="row">
                        	<div class="one_half txtboxicn">
                                    <strong class="icn">$</strong> <input type="text" name="txtAmount" class="onlynumber required" placeholder="Enter the amount" value="<?php echo $arrData[0]['price'];?>"  />
                                </div>
                                    <div class="one_half">
                                 <input type="text" name="end_date" id="datetimepicker3" class="required" placeholder="End date :" value="<?php echo date("d-m-Y",strtotime($arrData[0]['end_date_time']));?>"/>
                                </div>
                                </div>
                                <input type="hidden" name="hdnFileCnt" value="<?php echo ($intAttach+1);?>" id="hdnFileCnt" />
				<input type="submit" name="btnPost" value="Submit" />
                            </form>
                        
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
<script type="text/javascript">
    function getSubcat(intCat, intSelect,strSkill)
    { 
       jQuery.ajax({
            url: 'ajax.php',
            data: {intSelect: intSelect,strSkill:strSkill,intCat: intCat, CMD: "GET_SUBCATEGORY"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                var arrSk = data.split('~~~~~');
                jQuery("#subCat").html(arrSk[0]);
                //jQuery("#cmbSkills").html(arrSk[1]);
				jQuery("#skill_list").html(arrSk[2]);
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
    function removeAjax(strOb)
    {
        var intAttId = jQuery(strOb).attr("data-attr");
        jQuery.ajax({
           url:'ajax.php',
           type: 'POST',
           data:{CMD:"DEL_ATTCH",intPostId:'<?php echo $_GET['jobId'];?>',intAtId:intAttId},
           success: function (data)
            {
                if(data==1)
                {
                    var intCnt = parseInt(jQuery("#hdnFileCnt").val());
                    jQuery(strOb).parent("div.files").remove();
                    jQuery("#hdnFileCnt").val(intCnt - 1);
                }
            }
        });
    }
    
    jQuery(document).ready(function(){
       <?php if($_REQUEST['jobId']!='' &&  $arrData[0]['category_id']!=''): ?>
            getSubcat('<?php echo $arrData[0]['category_id'];?>','<?php echo $arrData[0]['sub_cat'];?>','<?php echo $arrData[0]['skills'];?>');
    <?php endif;?>     
    });
</script>    