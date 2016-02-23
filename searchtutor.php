<?php
include 'lib/module.php';
include 'lib/Pagination.php';
$arrTempSkills = $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");
foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
}
$arrCategory = $objModule->getCategory();
$arrCountry  = $objModule->getCountry();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
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
         $strCond = "User_type = '1' AND Status='1' ";
         if($_GET['sk_id']!='')
            {
                $_SESSION['search'] = array();
                $arrSkCateg    =    $objModule->getAll("SELECT * FROM tbl_skills WHERE sk_id = '".$_GET['sk_id']."' ");
                $strCond .=" AND FIND_IN_SET(".$_GET['sk_id'].",skills) ";
            }
        ?>
        <?php include('includes/header_top.inc.php'); ?>
        <?php 
           
            $intNum = MAX_RECORD_PER_PAGE;
            $intStart = ($objModule->getRequest("pagination-page", "") != '') ? ($intNum * $objModule->getRequest("pagination-page", "") - $intNum) : 0;
            if($_GET['cmbSkills']!='')
            {
                $intSkill = $_GET['cmbSkills'];
            }
            if($arrSkCateg[0]['cat_id']!='')
            {
                $_SESSION['search'] = array();
                $intCat     =   $arrSkCateg[0]['cat_id'];
                $intSkill   =   $_GET['sk_id'];
            }
            if($_SESSION['search']['cat_id']!='')
            {
                $intCat     =   $_SESSION['search']['cat_id'];
                $strCond   .=   " AND cat_id = '".$_SESSION['search']['cat_id']."' ";
            }
            if($_SESSION['search']['Searchkeyword']!='')
            {
                $strCond   .=   " AND (fname LIKE '%".$_SESSION['search']['Searchkeyword']."%' OR lname LIKE '%".$_SESSION['search']['Searchkeyword']."%'  OR description LIKE '%".$_SESSION['search']['Searchkeyword']."%' ) ";
            }


            if ($_GET['btnSearch'] != '')
            {
                $_SESSION['search'] = array();
                if ($_GET['cmbCategory'] != '')
                {
                    $strCond .= " AND FIND_IN_SET(" . $_GET['cmbCategory'] . ",cat_id)";
                }
                if ($_GET['cmbSkills']!='')
                {
                    $strCond .= "AND FIND_IN_SET(" . $_GET['cmbSkills'] . ",skills)";
                }
                if($_GET['cmbCountry']!='')
                {
                    $strCond .= "AND  Country = '".$_GET['cmbCountry']."'";
                }
                if($_GET['txtCity']!='')
                {
                    $strCond .= "AND  (City LIKE '%".$_GET['txtCity']."%') OR  (State LIKE '%".$_GET['txtCity']."%')";
                }
            }
            
            $strSql = "tbl_users tu LEFT JOIN tbl_reviews tr ON tr.review_to = tu.Id";
            $arrTutor = $objModule->getAll($strSql, array("tu.*","AVG(tr.review_rate) as avg_rate"), $strCond, "Id", "Id DESC", $intStart, $intNum);
            $intTotal = $objModule->intTotalRows;
            $objPagination = new Pagination($intTotal, MAX_PAGE_NUMBER_PER_SECTION, $intNum);
        ?>
        <div class="header">
            <ul class="slides">
                <li>
                    <div class="header_main">
                        <div class="header_img"><img src="images/about_inner.jpg" alt="" /></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Search Tutor</h1>
<!--                                <div class="button_box2"> <a href="#">Post an assignment</a> </div>-->
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
                            <form method="get" name="frmSearch" action="<?php echo $objModule->SITEURL;?>searchtutor.php">
                            	<div class="row">
                                	<div class="one_full"><label>Category</label>
	
                                            <select name="cmbCategory" id="cmbCategory" onchange="getSkills(this.value,'');">
	
	                                        <option value="">All Categories</option>
	
	                                        <?php foreach ($arrCategory as $intKey => $strValue): ?>
	
	                                            <option value="<?php echo $strValue['id']; ?>" <?php if($strValue['id']==$intCat): echo 'selected'; endif;?> <?php if($strValue['id']==$_GET['cmbCategory']): echo 'selected'; endif; ?>><?php echo $strValue['name']; ?></option>
	
	                                        <?php endforeach; ?>    
	
	                                    </select></div>
                                </div>
                                <div class="row">
                                	<div class="one_full"><label>Skills</span></label>
	
	                                    <select name="cmbSkills" id="cmbSkills" >
	                                        <option value="">Select</option>
                                            </select></div>
                                </div>
                                <div class="row">
                                	<div class="one_full"><label>Country</span></label>
	
	                                    <select name="cmbCountry" id="cmbCountry" >
	
	                                        <option value="">Select</option>
	
	                                        <?php foreach ($arrCountry as $strCounty): ?>
	
	                                            <option value="<?php echo $strCounty['Id']; ?>" <?php if ($strCounty['Id'] == $_GET['cmbCountry']): echo 'selected';
	
	                                        endif; ?>><?php echo $strCounty['Name']; ?></option>
	
	                                       <?php endforeach; ?>    
	
	                                    </select></div>
                                </div>
                                <div class="row">
                                	<div class="one_full"><label>City or State</span></label>
	
                                            <input type="text" name="txtCity"  value="<?php echo $_GET['txtCity'];?>"/></div>
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
                        <div class="blog_found">Showing<span><?php echo $intTotal; ?></span>Tutors</div>
                            <?php 
                            if (!empty($arrTutor)): ?>
                                <?php foreach ($arrTutor as $intKey => $strValue):
                                    $intRate = 0;
                                    if($strValue['avg_rate'] !=''){$intRate = $strValue['avg_rate'];}
                                    ?>
                                    <div class="blog_box">
                                        <div class="tutors_people">
                                            <?php if(file_exists("upload/user/".$strValue['Photo']) && $strValue['Photo']!=''):?>
                                                <img src="<?php echo $objModule->SITEURL;?>timthumb.php?src=<?php echo $objModule->SITEURL;?>upload/user/<?php echo $strValue['Photo']; ?>&w=100&h=100&a=t" alt="" />
                                                <!--<img src="upload/user/<?php /*echo $strValue['Photo'];*/?>" alt="" />-->
                                            <?php else:?>
                                                <img src="images/default.png" alt="" />
                                            <?php endif;?>
                                            
                                        </div>
                                        <div class="tutors_right">
                                            <div class="blog_fullbox">
                                                <div class="blog_titel">
                                                    <h2><a href="<?php echo $objModule->SITEURL;?>tutors_profile.php?id=<?php echo $strValue['Id'];?>"><?php echo ucfirst($strValue['disp_name']);?></a></h2>
                                                </div>
                                                <div class="blog_price reating">
                                                    <ul>
                                                        <li><span class="red"><?php echo $intRate;?></span>/5 <img src="images/gold_star/star_<?php echo $objModule->roundDownToHalf($intRate); ?>.png" alt="" /></li>
                                                        <li>$<a href="#"><span class="money"><?php echo ($strValue['h_rate']?$strValue['h_rate']:"N/A");?></span></a><?php echo ($strValue['h_rate']?"/hours":"&nbsp;");?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php if($strValue['skills']!=''):?>
                                                <?php 
                                                $arrS = array();
                                                $arrS = @explode(',',$strValue['skills']);
                                                ?>
                                                    <div class="blog_tag">
                                                        <?php foreach($arrS as $intS=>$strS):
                                                                if($arrSkill[$strS]!='')
                                                                {
                                                                    ?>
                                                        <a class="<?php if($intSkill==$strS): echo 'active';endif;?>" href="searchtutor.php?sk_id=<?php echo $strS;?>"><?php echo ucfirst($arrSkill[$strS]);?></a>
                                                        <?php

                                                                }
                                                            ?>

                                                        <?php endforeach;?>
                                                    </div>
                                            <?php endif;?>
                                            <div class="blog_text">
                                                <p>
                                                    <?php if(strlen($strValue['description'])>300): ?>
                                                    <?php echo substr($strValue['description'], 0, 300);?>
                                                    ... <a href="<?php echo $objModule->SITEURL;?>tutors_profile.php?id=<?php echo $strValue['Id'];?>">more</a>
                                                    <?php else:?>
                                                    <?php echo stripslashes($strValue['description']);?> 
                                                    <?php endif;?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                             <?php else:?>
                             No Tutors found.
                            <?php endif;?>
                        
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
                    </div>
                </div>
                <!----content End----> 
            </div>
        </div>
<?php include('includes/footer.inc.php'); ?>
    </body>
</html>
<script type="text/javascript">
function getSkills(intCat,intSkill)
    {
        jQuery.ajax({
                url: 'ajax.php',
                data: {intSkill:intSkill,intCat:intCat,CMD:"GET_SKILLS"},
                type: 'POST',
                cache: true,
                success: function (data)
                {
                    jQuery("#cmbSkills").html(data);
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
            getSkills('<?php echo $intCat;?>','<?php echo $intSkill;?>');    
       <?php endif;?>        
    });
</script>   