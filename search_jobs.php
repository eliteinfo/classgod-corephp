<?php
include 'lib/module.php';
include 'lib/Pagination.php';
//error_reporting(E_ALL);
$arrTempSkills =    $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");
foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
}
$arrCategory = $objModule->getCategory();
if($_SESSION['classgod_User'][0]['User_type']=='0')
{
    $objModule->redirect("./dashboard-buyer.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
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
        
        <?php 
        $strCond = "tp.win_status = '0' AND tp.status = '1'";
        if($_GET['sk_id']!='')
        {
            $_SESSION['search'] = array();
            $arrSkCateg    =    $objModule->getAll("SELECT * FROM tbl_skills WHERE sk_id = '".$_GET['sk_id']."' ");
            $strCond .=" AND FIND_IN_SET(".$_GET['sk_id'].",tp.skills) ";
        }
        ?>
       <?php include('includes/header_top.inc.php');?>
       <?php 
        // for select skills
        if($_GET['cmbSkills']!='')
        {
            $_SESSION['search'] = array();
            $intSkill = $_GET['cmbSkills'];
        }
        if($arrSkCateg[0]['cat_id']!='')
        {
            $_SESSION['search'] = array();
            $intCat     =   $arrSkCateg[0]['cat_id'];
            $intSkill   =   $_GET['sk_id'];
        }
        if($_SESSION['search']['cat_id']!='' && $_REQUEST['explor']=='')
        {
            $intCat     =   $_SESSION['search']['cat_id'];
            $strCond   .=   " AND tp.category_id = '".$_SESSION['search']['cat_id']."' ";
        }
        if($_SESSION['search']['Searchkeyword']!='' && $_REQUEST['explor']=='')
        {
            $strCond   .=   " AND (tp.title LIKE '%".$_SESSION['search']['Searchkeyword']."%' OR tp.description LIKE '%".$_SESSION['search']['Searchkeyword']."%') ";
        }
        
        

    if($_GET['btnSearch']!='')
    {
        $_SESSION['search'] = array();
        if($_GET['cmbCategory']!='')
        {
            $strCond .= " AND tp.category_id = '".$_GET['cmbCategory']."' ";
        }
        if($_GET['cmbSkills']!='')
        {
            $strCond .= " AND FIND_IN_SET(".$_GET['cmbSkills'].",tp.skills)  ";
        }
        if($_GET['cmbSubCategory']!='')
        {
            $strCond .= " AND tp.sub_cat = '".$_GET['cmbSubCategory']."' ";
        }
        if($_GET['min']!='' && $_GET['max']!='')
        {
            $strCond .= " AND tp.price between ".$_GET['min']." AND ".$_GET['max']."  ";
        }
        if($_GET['cmbPostTime']!='')
        {
            $strCond .= " AND HOUR(TIMEDIFF('".date("Y-m-d H:i:s")."',tp.created_date)) < ".$_GET['cmbPostTime']."  ";
        }
        if($_GET['cmbLeftTime']!='')
        {
            $strCond .= " AND HOUR(TIMEDIFF(tp.end_date_time,'".date("Y-m-d H:i:s")."')) < ".$_GET['cmbLeftTime']."  ";
        }
    }
    $intNum     =   MAX_RECORD_PER_PAGE;
    $intStart   =   ($objModule->getRequest("pagination-page", "") != '')?($intNum * $objModule->getRequest("pagination-page", "")-$intNum):0;
    $strSql = "tbl_post tp INNER JOIN tbl_users tu on tu.Id = tp.uid";
    $arrPostJob = $objModule->getAll($strSql,array("tp.*"),$strCond,"id","id DESC",$intStart,$intNum);
    $intTotal   = $objModule->intTotalRows;
    $objPagination = new Pagination($intTotal,MAX_PAGE_NUMBER_PER_SECTION,$intNum);

        ?>
        <!----Top End----> 
        <!----header Start---->
        <div class="header">
            <ul class="slides">
                <li>
                    <div class="header_main">
                        <div class="header_img"><img src="images/about_inner.jpg" alt="" /></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Find Jobs</h1>
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
                        <a class="category_top" href="#">Category</a>
                        <div class="category_box">
                        	<div class="sidebar_box regform mrgtop0">
           <form method="GET" action="<?php echo $objModule->SITEURL;?>search_jobs.php">
            	<div class="row">
                	<div class="one_full"> <label>Category</label>
                                    <select name="cmbCategory" id="cmbCategory" onchange="getSubcat(this.value,'')">
                                        <option value="">All Categories</option>
                                        <?php foreach ($arrCategory as $intKey => $strValue): ?>
                                        <option value="<?php echo ($strValue['id']);?>" <?php if($strValue['id']==$intCat): echo 'selected'; endif;?> <?php if($strValue['id']==$_GET['cmbCategory']): echo 'selected'; endif; ?>><?php echo $strValue['name']; ?></option>
                                        <?php endforeach; ?>    
                                    </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><label>Sub Category</label>
                                        <select name="cmbSubCategory" id="cmbSubCategory">
                                            <option value="">Select</option>
                                        </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><label>Skills</label>
                                        <select name="cmbSkills" id="cmbSkills">
                                            <option value="">Select</option>
                                        </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><label>Any Budget</span></label>
                                    <input type="text" name="min" placeholder="Min"  value="<?php echo $_GET['min'];?>" /> <br/>
                                    <input type="text" name="max" placeholder="Max" value="<?php echo $_GET['max'];?>" class="mrgtop10" /></div>
                </div>
                <div class="row">
                	<div class="one_full"><label>Any  Time Left</label>
                                    <select name="cmbLeftTime" id="cmbLeftTime">
                                        <option value="">Select</option>
                                        <option value="24" <?php if($_GET['cmbLeftTime']==24): echo 'selected'; endif; ?>>Last 24 Hours</option>
                                        <option value="72" <?php if($_GET['cmbLeftTime']==72): echo 'selected'; endif; ?>>Last 3 Days</option>
                                        <option value="168" <?php if($_GET['cmbLeftTime']==168): echo 'selected'; endif; ?>>Last 7 Days</option>
                                    </select></div>
                </div>
                <div class="row">
                	<div class="one_full"><label>Any Posted Date</label>
                                    <select name="cmbPostTime" id="cmbPostTime">
                                        <option value="">Select</option>
                                        <option value="24" <?php if($_GET['cmbPostTime']==24): echo 'selected'; endif; ?>>Posted within 24 hours</option>
                                        <option value="72" <?php if($_GET['cmbPostTime']==72): echo 'selected'; endif; ?>>Posted within 3 days</option>
                                        <option value="168" <?php if($_GET['cmbPostTime']==168): echo 'selected'; endif; ?>>Posted within 7 days</option>
                                    </select></div>
                </div>
                <div class="row sbmt">
                	<div class="one_full"><input type="submit" name="btnSearch" value="Search" /></div>
                </div>
                </form>
          </div>    
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <div class="blog_found"><span>
                            <?php echo $intTotal;?></span> job<?php if($intTotal>0) echo "s"; ?> found </div>
                        <?php 
                        $strCur = date("Y-m-d H:i:s");
                        if(!empty($arrPostJob)):
                        foreach ($arrPostJob as $intKey => $strValue): ?>
                            <div class="blog_box">
                                <div class="blog_fullbox">
                                    <div class="blog_titel">
                                        <h2><a href="job_detail.php?post_id=<?php echo $strValue['id'];?>&post_uid=<?php echo $strValue['uid'];?>"><?php echo $strValue['title']; ?></a></h2>
                                    </div>
                                    <div class="blog_price">
                                        <ul>
                                           <li><a href="javascript:;">Est. Budget</a></li>
                                            <li>$<a href="javascript:;"><span class="money"><?php echo $strValue['price']; ?></span></a></li>
                                        </ul>
                                        <span class="blog_time">Posted
                                            <?php echo $objModule->timeDiff($strValue['created_date'], $strCur); ?>
                                        </span> 
                                    </div>
                                </div>
                                <?php if($strValue['skills']!=''):?>
                                    <?php 
                                    $arrS = array();
                                    $arrS = @explode(',',$strValue['skills']);
                                    ?>
                                        <div class="blog_tag">
                                            <?php foreach($arrS as $intS=>$strS):?>
                                            <a  class="<?php if($intSkill==$strS): echo 'active';endif;?>"  href="search_jobs.php?sk_id=<?php echo $strS;?>"><?php echo ucfirst($arrSkill[$strS]);?></a>
                                            <?php endforeach;?>
                                        </div>
                                <?php endif;?>
                                <div class="blog_text">
                                    <p>
                                        <?php if(strlen($strValue['description'])<300):
                                                echo $strValue['description'];
                                              else:
                                                echo $strValue['description'].'....';  
                                              endif;  
                                        ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php else:?>
                        <div class="blog_box">
                                <div class="blog_fullbox">
                                    <div class="blog_titel">
                                        No Post found for this criteria. <a href="<?php echo $objData->SITEURL; ?>search_jobs.php?explor=<?php echo base64_encode(rand()); ?>">Click Here</a> to explore more!
                                    </div>
                                </div>
                        </div>    
                        <?php endif;?>
                        <!----navigation Start---->
                        <?php if($intTotal >$intNum): ?>
                        <div class="navigation">
                            <?php echo $objPagination->display().$objPagination->displaySelectInterface(); ?>
<!--                            <ul>
                                <li><a href="#">First</a></li>
                                <li class="current_selected_page"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Last</a></li>
                            </ul>-->
                        </div>
                        <?php endif;?>
                        <!----navigation End----> 
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
function getSubcat(intCat,intSelect,intSkill)
    {
        jQuery.ajax({
                url: 'ajax.php',
                data: {intSelect:intSelect,intSkill:intSkill,intCat:intCat,CMD:"GET_SUBCATSEARCHJOB"},
                type: 'POST',
                cache: true,
                success: function (data)
                {
                    var arrSk = data.split('~~~~~');
                    jQuery("#cmbSubCategory").html(arrSk[0]);
                    jQuery("#cmbSkills").html(arrSk[1]);
                }
            });
    }
    jQuery(document).ready(function(){
       <?php if($_GET['cmbCategory']!='' || $intCat!=''):
                if($_GET['cmbCategory']!='')
                {
                    $intCat = $_GET['cmbCategory'];
                }
           ?>
            getSubcat('<?php echo $intCat;?>','<?php echo $_GET['cmbSubCategory'];?>','<?php echo $intSkill;?>');    
       <?php endif;?>        
    });
</script>
