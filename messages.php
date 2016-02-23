<?php 

include 'lib/module.php';

include 'lib/Pagination.php';

if ($_SESSION['clg_userid'] == '')

{

    $objModule->redirect("./login.php");

}

$intNum     =   10;

$intStart   =   ($objModule->getRequest("pagination-page", "") != '')?($intNum * $objModule->getRequest("pagination-page", "")-$intNum):0;

$strTable   =   "`tbl_messages` tm

		INNER JOIN `tbl_users` tu ON (tu.`Id` = tm.`From_user`) OR (tu.`Id` = tm.`To_user`)

		INNER JOIN `tbl_post` tp ON tp.`id` = tm.`Post_id` ";

$strCond    =   "tu.`Id` = '".$_SESSION['clg_userid']."'";

$strGroupby =   "tp.id";

$arrPost = $objModule->getAll($strTable,array("tp.`id` AS post_id","tp.title","tm.`From_user`","tm.`To_user`"),$strCond,$strGroupby,"tp.id DESC",$intStart,$intNum);

//echo "<pre>";print_r($objModule);die;

$intTotal   = $objModule->intTotalRows;

$objPagination = new Pagination($intTotal,MAX_PAGE_NUMBER_PER_SECTION,$intNum);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title>Class God</title>

    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />

    <link href="css/style.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/script.js"></script>

    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

    <script type="text/javascript" src="js/expand.js"></script>

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

            <h1>Messages</h1>

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

  <?php include 'includes/turor_lefbar.inc.php'; ?>

  <!----Sidebar end---->

  <div class="blog_part">

  	<h2><span>Messages</span></h2>

        <ul class="jobmsg-list">

            <?php if(!empty($arrPost)): ?>

                <?php foreach($arrPost as $intKey=>$strValue):

                    $arrTempUnread = $objModule->getAll("SELECT COUNT(*) as tunred FROM `tbl_messages` tm WHERE tm.`To_user` = '".$_SESSION['clg_userid']."' AND tm.Post_id = '".$strValue['post_id']."'  AND tm.`is_read` = '0'");

                    if($strValue['From_user']==$_SESSION['clg_userid']):

                        $intTo = $strValue['To_user'];

                    else:

                        $intTo = $strValue['From_user'];

                    endif;

                    ?>

            <li><div class="post-dt"><?php echo $arrTempUnread[0]['tunred'];?> msg</div><div class="jobtitle"><h2><a href="messages_detail.php?from=<?php echo $_SESSION['clg_userid'];?>&to=<?php echo $intTo;?>&post_id=<?php echo $strValue['post_id'];?>"><?php echo $strValue['title'];?></a></h2></div></li>

                <?php endforeach;?>

            <?php endif;?>

        </ul>

        <!----navigation Start---->

        <?php if($intTotal >$intNum): ?>

                        <div class="navigation">

                            <?php echo $objPagination->display().$objPagination->displaySelectInterface(); ?>

                        </div>

                        <?php endif;?>

        <!----navigation End----> 

      </div>



</div>

    <!----content End----> 

</div>

</div>

<!----mid End----> 

<?php include('includes/footer.inc.php'); ?>

<!----Footer Start---->

           

    </body>

</html>