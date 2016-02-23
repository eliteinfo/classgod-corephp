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
   $objModule->redirect("./edit_skill.php");
}
if($_POST['btnAddskills']!='')
{
    $strTempSk = trim($_POST['skills'],',');
    $arrsuggestSkill=explode(",",$strTempSk);
    $ins='';
    if(count($arrsuggestSkill)>0)
    {
        foreach($arrsuggestSkill as $skill)
        {
            $ins.=" (null,'".$_SESSION['clg_userid']."','".$_REQUEST['cmbCategory']."','".$skill."'),";
        }
        $ins=rtrim($ins,",");
        $objData->getAll("insert into tmp_skills(id,uid,cat_id,skills)values ".$ins);
    }
    unset($objData);
    /*if($strTempSk!='')
    {
        $objData = new PCGData();
        $objData->setTableDetails("tmp_skills","id");
        $objData->setFieldValues("uid",$_SESSION['clg_userid']);
        $objData->setFieldValues("cat_id",$_POST['cmbCategory']);
        $objData->setFieldValues("skills",$strTempSk);
        $objData->insert();
    }*/
    $objModule->redirect("./edit_skill.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Class God</title>
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />    
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js"></script>    
    <script type="text/javascript" src="js/expand.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
$("ul.menu li:has(ul)").addClass("parent");
$(".menu_link").click(function(){
$(this).next("ul").slideToggle(400);
return false;
});
$(".menu_link").toggle(function(){
$(this).addClass("active");
}, function () {
$(this).removeClass("active");
});
});
</script>
    <script type="text/javascript">
    $(document).ready(function(){
  $(".sug_skil").fancybox({
                        maxWidth	: 300,
                        maxHeight	: 300,
                        fitToView	: false,
                        width		: '70%',
                        height		: '70%',
                        autoSize	: true,
                        closeClick	: false,
                        openEffect	: 'none',
                        closeEffect	: 'none'
                });		
        $(".custom-select").each(function(){
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    })
</script>
    <script>
        $(document).ready(function () {
        $("#faqs div.expand_title").toggler();
		$("#accordion div.expand_title").toggler();
        });
    </script>
    <script type="text/javascript">
	$(document).ready(function(){
	$(".category_top").click(function(){
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
            <h1>Edit Skill</h1>
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
   <?php include 'includes/turor_lefbar.inc.php';?>
  <!----Sidebar end---->
  <div class="blog_part">
    <h2><span>Manage Skills</span></h2>
     
     
     <h3 style="text-align:right"><a class="sug_skil" href="#inline_conent">Suggest New Skill</a></h3>
     
     <div style="display: none;" id="inline_conent">
     	<div class="popup-cont">
     	<h2>Suggest Skills</h2>
     						<div class="regform">
                            <form onsubmit="return frmvalidate(this.id);" name="frmAddskill" id="frmAddSkills" action="" method="POST">
                            	<div class="row">
                                    <div class="one_full">
                                         <select class="required" name="cmbCategory">
                                            <option value="">-Select Category-</option>
                                              <?php foreach($arrCategory as $intKey=>$strValue): ?>
                                            <option value="<?php echo $strValue['id'];?>"><?php echo $strValue['name'];?></option>
                                        <?php endforeach;?>                                          
                                        </select>	
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="one_full">
                                        <textarea placeholder="Add comma separated skills" name="skills" class="required" maxlength="500"></textarea>
                                    </div>
                                </div>
                                <div class="row last">   
                                    <div class="one_full">
                                        <input type="submit" name="btnAddskills" value="Add">
                                    </div>	
                                </div>
                            </form>                              
                            </div>
                         </div>       
                            </div>
                            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)">
                                <div class="fancybox-inner">
                                           <ul class="category">
                                               <li class="a"><a data-attr="ALL" href="javascript://">All</a></li> 
                                               <?php foreach($arrCategory as $intKey=>$strValue):
               $skillscount=$objData->getAll("select count(*)  from tbl_skills where cat_id='".$strValue['id']."'");
                                                   if($skillscount[0]['count(*)']>0)
                                                   {
                                                       ?>
                                                       <li><a data-attr="<?php echo $strValue['id'];?>" href="javascript://"><?php echo ucfirst($strValue['name']);?></a></li>
                                                   <?php

                                                   }
                                                   ?>

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
<!----content End----> 
  </div>
</div>
<!----mid End----> 
<!----Footer Start---->
<?php include('includes/footer.inc.php'); ?> 
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
   
    </body>
</html>