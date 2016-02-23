<?php 

include 'lib/module.php';

$intUserId = base64_decode($_REQUEST['u']);

if($intUserId=='')

{

   $objModule->redirect("./index.php");

}

$arrCategory = $objModule->getAll("SELECT * FROM tbl_category ORDER BY name ASC");

$arrSkills = $objModule->getAll("SELECT tss.* FROM tbl_skills tss ORDER BY sk_id ASC");



if($_POST['btnSubmit']!='')

{

   if(!empty($_POST['skills'])) 

   {

        $strSkills = @implode(',', $_POST['skills']);

        

        $objData = new PCGData();

        $objData->setTableDetails("tbl_users","Id");

        $objData->setFieldValues("skills",$strSkills);

        $objData->setWhere("Id",$intUserId);

        $objData->update();

        unset($objData);

   }

   $objModule->redirect("./thanks.php");

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <title>Class God</title>

        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />

        <link href="css/style.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="js/script.js"></script>

        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

        <script type="text/javascript" src="js/jquery.fancybox.js"></script>

        <script type="text/javascript" src="js/common.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                $(".various").fancybox({

                        maxWidth	: 800,

                        maxHeight	: 600,

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

        <div class="mid">

<div class="wrapper"> 

<!----content Start---->

<div class="content_part">



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

                        <input type="checkbox" name="skills[]" class="chk_sk" value="<?php echo $strValue['sk_id'];?>" />

                                <?php echo ucfirst($strValue['sk_name']);?>

                                </label>

                        </li>    

                        <?php endforeach;?>

                    </ul>

                </div>

               <input type="submit" name="btnSubmit" value="Submit" />

               <a href="<?php echo $objModule->SITEURL;?>thanks.php" class="skip-link">Skip</a>

                

            </form>





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

            //jQuery(".category li").removeClass("active");

            //alert(jQuery(this).parent("li").attr("class"));

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