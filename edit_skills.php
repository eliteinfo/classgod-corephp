<?php
include 'lib/module.php';
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if ($_SESSION['clg_usertype'] == 0)
{
    // redirect to tutor dashboard
    $objModule->redirect("./buydashboard.php");
}
$arrCategory = $objModule->getAll("SELECT * FROM tbl_category ORDER BY name ASC");
$arrSkills = $objModule->getAll("SELECT tss.* FROM tbl_skills tss ORDER BY sk_id ASC");
$arrUserDetail = $objModule->getAll("SELECT tu.*,tc.Name as cname FROM tbl_users tu 
                                        LEFT JOIN tbl_country tc ON tc.Id = tu.Country 
                                    WHERE tu.Id = '".$_SESSION['clg_userid']."' AND tu.User_type = '1' GROUP BY tu.Id ");
$arrEditSkill       = array();
if($arrUserDetail[0]['skills']!='')
{
    $arrEditSkill = @explode(',', $arrUserDetail[0]['skills']);
}
if($_POST['btnSubmit']!='')
{
   if(!empty($_POST['skills'])) 
   {
        $strSkills = @implode(',', $_POST['skills']);
        
        $objData = new PCGData();
        $objData->setTableDetails("tbl_users","Id");
        $objData->setFieldValues("skills",$strSkills);
        $objData->setWhere("Id = '".$_SESSION['clg_userid']."' ");
        $objData->update();
        unset($objData);
   }
   $objModule->redirect("./tutors_profile.php");
}
if($_POST['btnAddskills']!='')
{
    $strTempSk = trim($_POST['skills'],',');
    if($strTempSk!='')
    {
        $objData = new PCGData();
        $objData->setTableDetails("tmp_skills","id");
        $objData->setFieldValues("uid",$_SESSION['clg_userid']);
        $objData->setFieldValues("cat_id",$_POST['cmbCategory']);
        $objData->setFieldValues("skills",$strTempSk);
        $objData->insert();
        unset($objData);
    }
    $objModule->redirect("./edit_skills.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                 $(".sug_skil").fancybox({
                        maxWidth	: 300,
                        maxHeight	: 300,
                        fitToView	: false,
                        width		: '70%',
                        height		: '70%',
                        autoSize	: false,
                        closeClick	: false,
                        openEffect	: 'none',
                        closeEffect	: 'none'
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
                        <div class="header_img"><img src="images/about_inner.jpg" alt="" /></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Add Skills</h1>
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
                            <div class="sidebar_box">
                                <h2><span>Profile</span></h2>
                                <ul>
                                    <li><a href="tutors_profile.php">Overview</a></li>
                                    <li><a href="job_tutor.php">Job History</a></li>
                                    <li><a href="edit_skills.php">Skills</a></li>
                                    <li><a href="edit_contractor.php">Contact Info</a></li>
                                    <li><a href="#">Review</a></li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <ul class="short_profile">
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon16.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>5.00</span></div>
                                        <div class="small_txt"><span><img src="images/icon15.png" alt="" /></span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon17.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>$99.66</span></div>
                                        <div class="small_txt"><span>Hourly Rate</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon18.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>15</span></div>
                                        <div class="small_txt"><span>Total Job Worked</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon19.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>2,339</span></div>
                                        <div class="small_txt"><span>Total Hours</span></div>
                                    </li>
                                    <li>
                                        <div class="round_bg"><span><img src="images/icon20.png" alt="" /></span></div>
                                        <div class="amount_txt"><span>Croatia</span></div>
                                        <div class="small_txt"><span>Opatija</span></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar_box">
                                <h2><span>Groups</span></h2>
                                <ul>
                                    <li><a href="#">Group A</a></li>
                                    <li><a href="#">Group B</a></li>
                                    <li><a href="#">Group C</a></li>
                                    <li><a href="#">Group D</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <div class="blog_box">
                            <a href="#inline_conent" class="sug_skil">Suggest Skills</a>
                            <div id="inline_conent" style="display: none;">
                                <form method="POST" action="" id="frmAddSkills" name="frmAddskill" onsubmit="return frmvalidate(this.id);">
                                    <h2>Suggest Skills</h2>
                                    <select name="cmbCategory" class="required">
                                        <option value="">-Select Category-</option>
                                        <?php foreach($arrCategory as $intKey=>$strValue): ?>
                                            <option value="<?php echo $strValue['id'];?>"><?php echo $strValue['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <br/>
                                    <textarea maxlength="500" class="required" name="skills" placeholder="Add comma separated skills"></textarea>
                                    <br/>
                                    <input type="submit" value="Add" name="btnAddskills" />
                                </form>
                            </div>
                            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)">
                                <div class="fancybox-inner">
                                           <ul class="category">
                                               <li class="a"><a data-attr="ALL" href="javascript://">All</a></li> 
                                               <?php foreach($arrCategory as $intKey=>$strValue): ?>
                                               <li><a data-attr="<?php echo $strValue['id'];?>" href="javascript://"><?php echo ucfirst($strValue['name']);?></a></li> 
                                               <?php endforeach;?>
                                           </ul>
                                           <ul class="skil">
                                                <?php foreach($arrSkills as $intKey=>$strValue): ?>
                                                <li class="cat_<?php echo $strValue['cat_id'];?> listskill">
                                                        <label>
                                                            <input type="checkbox" name="skills[]" <?php if(in_array($strValue['sk_id'], $arrEditSkill)): echo 'checked';endif;?> class="chk_sk" value="<?php echo $strValue['sk_id'];?>" />
                                                        <?php echo ucfirst($strValue['sk_name']);?>
                                                        </label>
                                                </li>    
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                       <input type="submit" name="btnSubmit" value="Submit" />
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
    jQuery(document).ready(function(){
       jQuery(".category li a").click(function(){
            jQuery(".category li").removeClass("active");
            jQuery(this).parent("li").addClass("class");
            var intCat = jQuery(this).attr("data-attr");
            if(intCat=="ALL")
            {
                jQuery(".listskill").show();
            }
            else
            {
                jQuery(".listskill").hide();
                jQuery(".cat_"+intCat).show();
            }
       });
       jQuery(".chk_sk").click(function(){
           var intLength = $('input.chk_sk:checked').length;
           if(intLength>50)
           {
               jQuery(this).prop("checked",false);
           }
       });
    });
</script>